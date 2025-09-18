@extends('layouts.app')

@push('title') Users @endpush

@push('plugin-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('styles')
    <style>
        .pagination-info { font-size: 14px; color: #6c757d; }
        .btn-icon.btn-sm { width: 32px; height: 32px; padding: 0; }
        .btn-icon.btn-sm i { font-size: 14px; }
        .py-50 { padding: 3rem 0; }
        .table th { border-top: none; font-weight: 600; color: #495057; }
    </style>
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endpush

@push('page-title')
    Users
@endpush

@push('page-actions')
    <a href="{{ route('users.create') }}" data-toggle="tooltip" data-original-title="Add User"
        class="btn btn-sm btn-primary btn-round waves-effect waves-classic ml-2">
        <i class="icon md-plus" aria-hidden="true"></i>
    </a>
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary panel-line" id="userPanel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Users Management</h3>
                        <div class="panel-actions">
                            <a class="panel-action icon md-minus" aria-expanded="true" data-toggle="panel-collapse" aria-hidden="true"></a>
                            <a class="panel-action icon md-fullscreen" data-toggle="panel-fullscreen" aria-hidden="true"></a>
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
                            <table id="users-table" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'roles', name: 'roles', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
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
