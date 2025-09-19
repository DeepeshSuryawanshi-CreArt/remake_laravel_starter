<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role_view')->only(['index', 'show']);
        $this->middleware('permission:role_create')->only(['create', 'store']);
        $this->middleware('permission:role_edit')->only(['edit', 'update']);
        $this->middleware('permission:role_delete')->only(['destroy']);
    }
    /**
     * Display a listing of the roles.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::withCount('permissions')->select(['id', 'name', 'guard_name', 'created_at']);
            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addColumn('actions', function ($role) {
                    return view('roles.partials.actions', compact('role'))->render();
                })
                ->addColumn('permissions', function ($role) {
                    $permissions = $role->permissions->take(3)->pluck('name')->toArray();
                    $badges = '';
                    foreach ($permissions as $permission) {
                        $badges .= '<span class="badge badge-info mr-1">' . $permission . '</span>';
                    }
                    if ($role->permissions->count() > 3) {
                        $badges .= '<span class="badge badge-secondary">+' . ($role->permissions->count() - 3) . ' more</span>';
                    }
                    return $badges ?: '<span class="badge badge-secondary">No Permissions</span>';
                })
                ->addColumn('user_count', function ($role) {
                    return '<span class="badge badge-success">' . (($role->users_count ?? 0)) . '</span>';
                })
                ->editColumn('created_at', function ($permission) {
                    return optional($permission->created_at)->format('M d, Y');
                })
                ->rawColumns(['actions', 'user_count', 'permissions'])
                ->make(true);
        }
        return view('roles.index');
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create([
            'name' => $request->validated('name'),
            'guard_name' => $request->validated('guard_name', 'web'),
        ]);

        // Assign permissions to role if provided
        if ($request->has('permissions') && is_array($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }

        activity('roles')
            ->performedOn($role)
            ->causedBy($request->user())
            ->event('created')
            ->withProperties([
                'attributes' => $role->toArray(),
                'permissions' => $request->permissions ?? [],
            ])
            ->log('Role created');

        return Redirect::route('roles.index')
            ->with('status', 'Role created successfully with permissions.');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role): View
    {
        $role->load('permissions');
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        $permissions = \Spatie\Permission\Models\Permission::orderBy('name')->get();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $old = $role->getOriginal();
        $oldPermissions = $role->permissions->pluck('name')->toArray();

        $role->update([
            'name' => $request->validated('name'),
            'guard_name' => $request->validated('guard_name', 'web'),
        ]);

        // Sync permissions if provided
        if ($request->has('permissions') && is_array($request->permissions)) {
            $role->syncPermissions($request->permissions);
        } else {
            // If no permissions selected, remove all permissions
            $role->syncPermissions([]);
        }

        activity('roles')
            ->performedOn($role)
            ->causedBy($request->user())
            ->event('updated')
            ->withProperties([
                'old' => $old,
                'attributes' => $role->toArray(),
                'old_permissions' => $oldPermissions,
                'new_permissions' => $request->permissions ?? [],
            ])
            ->log('Role updated');

        return Redirect::route('roles.index')
            ->with('status', 'Role updated successfully with permissions.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        activity('roles')
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->event('deleted')
            ->withProperties([
                'attributes' => $role->toArray(),
                'permissions' => $role->permissions->pluck('name')->toArray(),
            ])
            ->log('Role deleted');

        $role->delete();

        return Redirect::route('roles.index')
            ->with('status', 'Role deleted successfully.');
    }
}