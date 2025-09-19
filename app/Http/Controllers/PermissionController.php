<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{

    // Middleware setup in the couse.

    public function __construct()
    {
        $this->middleware('permission:permission_view')->only(['index', 'show']);
        $this->middleware('permission:permission_create')->only(['create', 'store']);
        $this->middleware('permission:permission_edit')->only(['edit', 'update']);
        $this->middleware('permission:permission_delete')->only(['destroy']);
    }

    /**
     * Display a listing of the permissions.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Permission::select(['id', 'name', 'guard_name', 'created_at']);
            return DataTables::of($query)
                ->addColumn('category', function ($permission) {
                    if (str_starts_with($permission->name, 'user_')) {
                        return '<span class="badge badge-primary">User Management</span>';
                    } elseif (str_starts_with($permission->name, 'role_')) {
                        return '<span class="badge badge-info">Role Management</span>';
                    } elseif (str_starts_with($permission->name, 'permission_')) {
                        return '<span class="badge badge-warning">Permission Management</span>';
                    } elseif (str_starts_with($permission->name, 'activity_')) {
                        return '<span class="badge badge-success">Activity Management</span>';
                    } else {
                        return '<span class="badge badge-secondary">Other</span>';
                    }
                })
                ->addColumn('display_name', function ($permission) {
                    return str_replace('_', ' ', ucfirst($permission->name));
                })
                ->addColumn('actions', function ($permission) {
                    return view('system.permissions.partials.actions', compact('permission'))->render();
                })
                ->editColumn('roles_count', function ($permission) {
                    return '<span class="badge badge-success">' . (($permission->roles_count ?? 0)) . '</span>';
                })
                // Render HTML for badges and action buttons
                ->rawColumns(['actions', 'category', 'roles_count'])
                ->editColumn('created_at', function ($permission) {
                    return optional($permission->created_at)->format('M d, Y');
                })
                ->make(true);
        }
    return view('system.permissions.index');
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create(): View
    {
    return view('system.permissions.create');
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $permission = Permission::create([
            'name' => $request->validated('name'),
            'guard_name' => $request->validated('guard_name', 'web'),
        ]);

        activity('permissions')
            ->performedOn($permission)
            ->causedBy($request->user())
            ->event('created')
            ->withProperties([
                'attributes' => $permission->toArray(),
            ])
            ->log('Permission created');

        return Redirect::route('permissions.index')
            ->with('status', 'Permission created successfully.');
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission): View
    {
    return view('system.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission): View
    {
    return view('system.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $old = $permission->getOriginal();
        $permission->update([
            'name' => $request->validated('name'),
            'guard_name' => $request->validated('guard_name', 'web'),
        ]);

        activity('permissions')
            ->performedOn($permission)
            ->causedBy($request->user())
            ->event('updated')
            ->withProperties([
                'old' => $old,
                'attributes' => $permission->toArray(),
            ])
            ->log('Permission updated');

        return Redirect::route('permissions.index')
            ->with('status', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        activity('permissions')
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->event('deleted')
            ->withProperties([
                'attributes' => $permission->toArray(),
            ])
            ->log('Permission deleted');

        $permission->delete();

        return Redirect::route('permissions.index')
            ->with('status', 'Permission deleted successfully.');
    }
}