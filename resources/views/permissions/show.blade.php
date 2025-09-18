@extends('layouts.app')

@push('title') Permission Details @endpush

@push('styles')
    <!-- Add any specific styles if needed -->
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
    <li class="breadcrumb-item active">Details</li>
@endpush

@push('page-title')
    Permission Details
@endpush

@push('page-actions')
    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary btn-sm ml-2">
        <i class="icon md-edit" aria-hidden="true"></i> Edit
    </a>
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12 col-lg-offset-2">
                <!-- Panel -->
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">Permission Details</h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse"
                                aria-hidden="true"></a>
                            <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen"
                                aria-hidden="true"></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="bg-grey-100" style="width: 200px;"><strong>ID</strong></td>
                                            <td>{{ $permission->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-grey-100"><strong>Permission Name</strong></td>
                                            <td>
                                                <span class="badge badge-outline badge-lg badge-primary">
                                                    {{ $permission->name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-grey-100"><strong>Guard Name</strong></td>
                                            <td>
                                                <span class="badge badge-outline badge-info">
                                                    {{ $permission->guard_name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-grey-100"><strong>Created At</strong></td>
                                            <td>{{ $permission->created_at->format('M d, Y \a\t h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-grey-100"><strong>Updated At</strong></td>
                                            <td>{{ $permission->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-20">
                            <div class="col-md-12">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary">
                                        <i class="icon md-edit" aria-hidden="true"></i> Edit Permission
                                    </a>
                                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST"
                                        style="display: inline-block;"
                                        onsubmit="return confirm('Are you sure you want to delete this permission? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ml-2">
                                            <i class="icon md-delete" aria-hidden="true"></i> Delete Permission
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Related Information -->
                        <div class="row mt-30">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h5><i class="icon md-info" aria-hidden="true"></i> Permission Usage</h5>
                                    <p class="mb-0">
                                        This permission can be assigned to roles or directly to users using the Spatie
                                        Permission package.
                                        It allows fine-grained access control throughout your application.
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