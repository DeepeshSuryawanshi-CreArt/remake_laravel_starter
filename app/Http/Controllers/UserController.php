<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user_view')->only(['index', 'show']);
        $this->middleware('permission:user_create')->only(['create', 'store']);
        $this->middleware('permission:user_edit')->only(['edit', 'update']);
        $this->middleware('permission:user_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with('roles')->select(['id', 'name', 'email', 'created_at']);
            return DataTables::of($query)
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->join(', ');
                })
                ->addColumn('actions', function ($user) {
                    $actions = '<div class="btn-group">';

                    if (auth()->user()->can('user_view')) {
                        $actions .= '<a href="' . route('users.show', $user) . '" class="btn btn-info btn-sm"><i class="icon md-eye"></i></a>';
                    }

                    if (auth()->user()->can('user_edit')) {
                        $actions .= '<a href="' . route('users.edit', $user) . '" class="btn btn-warning btn-sm"><i class="icon md-edit"></i></a>';
                    }

                    if (auth()->user()->can('user_delete')) {
                        $actions .= '
                            <form action="' . route('users.destroy', $user) . '" method="POST" style="display:inline;" class="delete-user-form" data-user-name="' . $user->name . '">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" data-user-id="' . $user->id . '" data-user-name="' . $user->name . '">
                                    <i class="icon md-delete"></i>
                                </button>
                            </form>
                        ';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->editColumn('created_at', function ($user) {
                    return optional($user->created_at)->format('M d, Y');
                })
                ->make(true);
        }
        return view('system.users.index');
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        return view('system.users.create', compact('roles'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }
        activity('users')
            ->performedOn($user)
            ->causedBy($request->user())
            ->event('created')
            ->withProperties([
                'attributes' => $user->toArray(),
            ])
            ->log('User created');
        return Redirect::route('users.index')->with('status', 'User created successfully.');
    }

    public function show(User $user): View
    {
        $user->load('roles');
        return view('system.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();
        $user->load('roles');
        return view('system.users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $old = $user->getOriginal();
        $user->update($data);
        // Always sync roles, even if none selected (revoke all)
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);
        activity('users')
            ->performedOn($user)
            ->causedBy($request->user())
            ->event('updated')
            ->withProperties([
                'old' => $old,
                'attributes' => $user->toArray(),
            ])
            ->log('User updated');
        $msg = count($roles) ? 'User updated successfully.' : 'User updated and all roles revoked.';
        return Redirect::route('users.index')->with('status', $msg);
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        activity('users')
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->event('deleted')
            ->withProperties([
                'attributes' => $user->toArray(),
            ])
            ->log('User deleted');
        return Redirect::route('users.index')->with('status', 'User deleted successfully.');
    }
}
