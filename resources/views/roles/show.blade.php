@extends('layouts.app')

@push('title') Role Details @endpush

@push('styles')
    <!-- Add any specific styles if needed -->
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@section('content')
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <!-- Panel -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Role Details</h3>
                    <div class="panel-actions">
                        <a href="{{ route('roles.index') }}" class="btn btn-default btn-sm">
                            <i class="icon md-arrow-left" aria-hidden="true"></i> Back to Roles
                        </a>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm">
                            <i class="icon md-edit" aria-hidden="true"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="bg-grey-100" style="width: 200px;"><strong>ID</strong></td>
                                        <td>{{ $role->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-grey-100"><strong>Role Name</strong></td>
                                        <td>
                                            <span class="badge badge-outline badge-lg badge-primary">
                                                {{ $role->name }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-grey-100"><strong>Guard Name</strong></td>
                                        <td>
                                            <span class="badge badge-outline badge-info">
                                                {{ $role->guard_name }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-grey-100"><strong>Created At</strong></td>
                                        <td>{{ $role->created_at->format('M d, Y \a\t h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-grey-100"><strong>Updated At</strong></td>
                                        <td>{{ $role->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Permissions List -->
                    <div class="row mt-20">
                        <div class="col-md-12">
                            <h5><i class="icon md-key" aria-hidden="true"></i> Permissions for this Role</h5>
                            @if($role->permissions->count())
                                <div class="mb-15">
                                    @foreach($role->permissions as $permission)
                                        <span class="badge badge-outline badge-info mb-5 mr-5">{{ $permission->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    <i class="icon md-alert" aria-hidden="true"></i> No permissions assigned to this role.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-20">
                        <div class="col-md-12">
                            <div class="btn-group" role="group">
                                <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
                                    <i class="icon md-edit" aria-hidden="true"></i> Edit Role
                                </a>
                                <form action="{{ route('roles.destroy', $role) }}" 
                                      method="POST" 
                                      style="display: inline-block;"
                                      onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="icon md-delete" aria-hidden="true"></i> Delete Role
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Related Information -->
                    <div class="row mt-30">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="icon md-info" aria-hidden="true"></i> Role Usage</h5>
                                <p class="mb-0">
                                    This role can be assigned to users and can have multiple permissions associated with it. 
                                    It provides a convenient way to group related permissions for user access control.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Panel -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Add any specific scripts if needed -->
@endpush