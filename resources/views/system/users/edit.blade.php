@extends('layouts.app')

@push('title') Edit User @endpush

@push('styles')
    <style>
        .form-section {
            border: 1px solid #e4e7ea;
            border-radius: 4px;
            padding: 15px;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endpush

@push('page-title')
    Edit User
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-2">
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit User: {{ $user->name }}</h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse"
                                aria-hidden="true"></a>
                            <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen"
                                aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-left">Name *</label>
                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
                                        autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-left">Email *</label>
                                <div class="col-md-10">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-2 col-form-label text-md-left">Password <small>(leave
                                        blank to keep current)</small></label>
                                <div class="col-md-10">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-2 col-form-label text-md-left">Confirm
                                    Password</label>
                                <div class="col-md-10">
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="roles" class="col-md-2 col-form-label text-md-left">Roles</label>
                                <div class="col-md-10">
                                    <select name="roles[]" id="roles" class="form-control" multiple>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Assign one or more roles to the user. To revoke all roles, click the button below.</small>
                                    <button type="button" class="btn btn-warning btn-sm mt-2" id="revoke-roles-btn">
                                        <i class="icon md-close" aria-hidden="true"></i> Revoke All Roles
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon md-check" aria-hidden="true"></i> Update User
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-default">
                                        <i class="icon md-close" aria-hidden="true"></i> Cancel
                                    </a>
@push('scripts')
<script>
    document.getElementById('revoke-roles-btn').addEventListener('click', function() {
        const rolesSelect = document.getElementById('roles');
        for (let i = 0; i < rolesSelect.options.length; i++) {
            rolesSelect.options[i].selected = false;
        }
    });
</script>
@endpush
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection