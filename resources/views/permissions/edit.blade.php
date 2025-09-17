@extends('layouts.app')

@push('title') Edit Permission @endpush

@push('styles')
    <!-- Add any specific styles for form if needed -->
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endpush

@push('page-title')
    Edit Permission
@endpush

@push('page-actions')
    <a href="{{ route('permissions.show', $permission) }}" class="btn btn-primary btn-sm ml-2">
        <i class="icon md-eye" aria-hidden="true"></i> View
    </a>
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-2">
                <!-- Panel -->
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Permission: {{ $permission->name }}</h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse"
                                aria-hidden="true"></a>
                            <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen"
                                aria-hidden="true"></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('permissions.update', $permission) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-left">Permission Name *</label>
                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $permission->name) }}" required
                                        autocomplete="name" placeholder="e.g., manage-users, edit-posts">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Enter a unique permission name using kebab-case (e.g., manage-users, edit-posts)
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="guard_name" class="col-md-2 col-form-label text-md-left">Guard Name</label>
                                <div class="col-md-10">
                                    <select id="guard_name" class="form-control @error('guard_name') is-invalid @enderror"
                                        name="guard_name">
                                        <option value="web"
                                            {{ old('guard_name', $permission->guard_name) == 'web' ? 'selected' : '' }}>Web
                                        </option>
                                        <option value="api"
                                            {{ old('guard_name', $permission->guard_name) == 'api' ? 'selected' : '' }}>API
                                        </option>
                                    </select>
                                    @error('guard_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Select the guard this permission applies to
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Created At</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        {{ $permission->created_at->format('M d, Y \a\t h:i A') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Updated At</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        {{ $permission->updated_at->format('M d, Y \a\t h:i A') }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 col-md-offset-3">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-default">
                                        <i class="icon md-close" aria-hidden="true"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon md-edit" aria-hidden="true"></i> Update Permission
                                    </button>
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
    <!-- Optimized scripts for permissions -->
    <script>
        $(document).ready(function () {
            // Initialize tooltips only if Bootstrap tooltip is available
            if (typeof $.fn.tooltip !== 'undefined') {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    </script>
    <!-- pages js -->
    <script src="{{ asset('global/js/Plugin/panel.js') }}"></script>
    <script src="{{ asset('assets/examples/js/uikit/panel-actions.js') }}"></script>
@endpush