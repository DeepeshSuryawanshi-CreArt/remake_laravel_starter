@extends('layouts.app')

@push('title') Roles @endpush

@push('plugin-styles')
    <!-- Only load what we need for this page -->
    <link rel="stylesheet" href="{{ asset('global/vendor/flag-icon-css/flag-icon.css') }}">
@endpush

@push('styles')
    <!-- Optimized styles for roles page -->
    <style>
        .pagination-info {
            font-size: 14px;
            color: #6c757d;
        }

        .btn-icon.btn-sm {
            width: 32px;
            height: 32px;
            padding: 0;
        }

        .btn-icon.btn-sm i {
            font-size: 14px;
        }

        .py-50 {
            padding: 3rem 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
    </style>
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item active">Roles</li>
@endpush

@push('page-title')
    Roles
@endpush
@push('page-actions')
    <a href="{{ route('roles.create') }}" data-toggle="tooltip" data-original-title="Add Role"
        class="btn btn-sm btn-primary btn-round waves-effect waves-classic ml-2">
        <i class="icon md-plus" aria-hidden="true"></i>
    </a>
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel -->
                <div class="panel panel-primary panel-line" id="examplePannel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Roles Management
                            <span class="badge badge-pill badge-info">{{ $roles->total() }}</span>
                        </h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse"
                                aria-hidden="true"></a>
                            <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen"
                                aria-hidden="true"></a>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel-body">
                        @if($roles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Guard Name</th>
                                            <th>Permissions</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                                                <td>
                                                    <strong>{{ $role->name }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-outline badge-primary">{{ $role->guard_name }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-success">{{ $role->permissions_count }} permissions</span>
                                                </td>
                                                <td>{{ $role->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('roles.show', $role) }}"
                                                            class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip"
                                                            title="View">
                                                            <i class="icon md-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="{{ route('roles.edit', $role) }}"
                                                            class="btn btn-sm btn-icon btn-pure btn-default" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="icon md-edit" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                                            style="display: inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-icon btn-pure btn-default"
                                                                data-toggle="tooltip" title="Delete">
                                                                <i class="icon md-delete" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-20">
                                <div class="pagination-info">
                                    <span class="text-muted">
                                        Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of
                                        {{ $roles->total() }} results
                                    </span>
                                </div>
                                <div class="pagination-wrapper">
                                    {{ $roles->links('components.pagination') }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-50">
                                <i class="icon md-account-circle font-size-40 grey-300"></i>
                                <h4 class="grey-400 mt-20">No roles found</h4>
                                <p class="grey-400">Start by creating your first role.</p>
                                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                    <i class="icon md-plus" aria-hidden="true"></i> Add Role
                                </a>
                            </div>
                        @endif
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
        });
    </script>
    <!-- pages js -->
    <script src="{{ asset('global/js/Plugin/panel.js') }}"></script>
    <script src="{{ asset('assets/examples/js/uikit/panel-actions.js') }}"></script>
@endpush