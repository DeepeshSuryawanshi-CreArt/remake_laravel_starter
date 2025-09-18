@extends('layouts.app')

@push('title') Permissions @endpush

@push('plugin-styles')
    <!-- Only load what we need for this page -->
    <link rel="stylesheet" href="{{ asset('global/vendor/flag-icon-css/flag-icon.css') }}">
@endpush

@push('styles')
    <!-- Optimized styles for permissions page -->
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
    <li class="breadcrumb-item active">Permissions</li>
@endpush

@push('page-title')
    Permissions
@endpush
@push('page-actions')
    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm ml-2">
        <i class="icon md-plus" aria-hidden="true"></i> Add Permission
    </a>
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel -->
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Permissions Management
                        </h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-refresh-alt" data-toggle="panel-refresh"
                                data-load-type="round-circle" aria-hidden="true"></a>
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

                    <div class="panel-body col-12">
                        <div class="table-responsive">
                            <table id="permissions-table" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 30%">Name</th>
                                        <th style="width: 20%">Guard Name</th>
                                        <th style="width: 25%">Created At</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Panel -->
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            var table = $('#permissions-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                scrollX: true,
                ajax: '{{ route('permissions.index') }}',
                columns: [
                    { data: 'id', name: 'id', width: '5%' },
                    { data: 'name', name: 'name', width: '30%' },
                    { data: 'guard_name', name: 'guard_name', width: '20%' },
                    { data: 'created_at', name: 'created_at', width: '25%' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, width: '20%' },
                ],
                order: [[1, 'asc']],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });
    </script>
    <script src="{{ asset('global/js/Plugin/panel.js') }}"></script>
    <script src="{{ asset('assets/examples/js/uikit/panel-actions.js') }}"></script>
@endpush