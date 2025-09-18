@extends('layouts.app')

@push('title') Create Role @endpush

@push('styles')
    <!-- Custom styles for role create form -->
    <style>
        .permissions-section {
            border: 1px solid #e4e7ea;
            border-radius: 4px;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .permission-name {
            font-size: 13px;
            margin-left: 5px;
        }
        .form-check {
            margin-bottom: 8px;
        }
        .form-check-label {
            cursor: pointer;
            font-weight: normal;
        }
        .form-check-input:checked + .permission-name {
            font-weight: 500;
            color: #007bff;
        }
    </style>
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Create</li>
@endpush

@push('page-title')
    Create Role
@endpush

@push('page-actions')
    
@endpush


@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-2">
                <!-- Panel -->
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">Create New Role</h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse"
                                aria-hidden="true"></a>
                            <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen"
                                aria-hidden="true"></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-left">Role Name *</label>
                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
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
                                <label for="guard_name" class="col-md-2 col-form-label text-md-left">Guard Name</label>
                                <div class="col-md-10">
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

                            <!-- Permissions Section -->
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label text-md-left">Permissions</label>
                                <div class="col-md-10">
                                    @if($permissions->count())
                                        <div class="permissions-section">
                                            <!-- Select All Option -->
                                            <div class="form-check mb-15">
                                                <label class="form-check-label">
                                                    <input type="checkbox" id="select-all-permissions" class="form-check-input">
                                                    <strong>Select All Permissions</strong>
                                                </label>
                                            </div>
                                            
                                            <!-- Permissions Grid -->
                                            <div class="row">
                                                @foreach($permissions->chunk(3) as $permissionChunk)
                                                    @foreach($permissionChunk as $permission)
                                                        <div class="col-md-4 mb-10">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" 
                                                                           name="permissions[]" 
                                                                           value="{{ $permission->name }}" 
                                                                           class="form-check-input permission-checkbox"
                                                                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                                                    <span class="permission-name">{{ $permission->name }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('permissions')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Select the permissions you want to assign to this role
                                        </small>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="icon md-info" aria-hidden="true"></i>
                                            No permissions available. Please create some permissions first.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 col-md-offset-3">
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
    <!-- Optimized scripts for roles -->
    <script>
        $(document).ready(function () {
            // Initialize tooltips only if Bootstrap tooltip is available
            if (typeof $.fn.tooltip !== 'undefined') {
                $('[data-toggle="tooltip"]').tooltip();
            }

            // Handle "Select All" checkbox
            $('#select-all-permissions').change(function() {
                $('.permission-checkbox').prop('checked', $(this).is(':checked'));
            });

            // Handle individual permission checkboxes
            $('.permission-checkbox').change(function() {
                var totalCheckboxes = $('.permission-checkbox').length;
                var checkedCheckboxes = $('.permission-checkbox:checked').length;
                
                // Update "Select All" checkbox state
                if (checkedCheckboxes === totalCheckboxes) {
                    $('#select-all-permissions').prop('checked', true);
                } else {
                    $('#select-all-permissions').prop('checked', false);
                }
            });
        });
    </script>
    <!-- pages js -->
    <script src="{{ asset('global/js/Plugin/panel.js') }}"></script>
    <script src="{{ asset('assets/examples/js/uikit/panel-actions.js') }}"></script>
@endpush