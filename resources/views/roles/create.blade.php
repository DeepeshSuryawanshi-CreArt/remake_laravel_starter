@extends('layouts.app')

@push('title') Create Role @endpush

@push('styles')
    <!-- Add any specific styles for form if needed -->
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Create</li>
@endpush

@push('page-title')
    Create Role
@endpush

@section('content')
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <!-- Panel -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Create New Role</h3>
                    <div class="panel-actions">
                        <a href="{{ route('roles.index') }}" class="btn btn-default btn-sm">
                            <i class="icon md-arrow-left" aria-hidden="true"></i> Back to Roles
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">Role Name *</label>
                            <div class="col-md-9">
                                <input id="name" 
                                       type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name" 
                                       autofocus
                                       placeholder="e.g., Admin, Manager, User">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Enter a unique role name (e.g., Admin, Manager, User)
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="guard_name" class="col-md-3 col-form-label text-md-right">Guard Name</label>
                            <div class="col-md-9">
                                <select id="guard_name" 
                                        class="form-control @error('guard_name') is-invalid @enderror" 
                                        name="guard_name">
                                    <option value="web" {{ old('guard_name') == 'web' ? 'selected' : '' }}>Web</option>
                                    <option value="api" {{ old('guard_name') == 'api' ? 'selected' : '' }}>API</option>
                                </select>
                                @error('guard_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">
                                    Select the guard this role applies to (default: web)
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon md-plus" aria-hidden="true"></i> Create Role
                                </button>
                                <a href="{{ route('roles.index') }}" class="btn btn-default">
                                    <i class="icon md-close" aria-hidden="true"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Panel -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Add any specific scripts for create form if needed -->
@endpush