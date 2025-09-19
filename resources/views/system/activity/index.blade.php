@extends('layouts.app')

@push('title') Activity Log @endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active">Activity Log</li>
@endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('page-title')
    Activity Log
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading">
                        <h3 class="panel-title">Activity Log</h3>
                    </div>
                    <div class="panel-body col-12">
                        <form id="activity-filter-form" class="form-inline mb-3" autocomplete="off">
                            <div class="form-group mr-2 mb-2">
                                <label for="user_id" class="mr-2">User</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">All Users</option>
                                    @foreach(\App\Models\User::role(['Admin','Manager'])->orderBy('name')->get() as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <label for="from_date" class="mr-2">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <label for="to_date" class="mr-2">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <label for="log_name" class="mr-2">Log Name</label>
                                <select name="log_name" id="log_name" class="form-control">
                                    <option value="all">All</option>
                                    @foreach(\Spatie\Activitylog\Models\Activity::distinct('log_name')->pluck('log_name') as $log)
                                        @if($log)
                                            <option value="{{ $log }}">{{ ucfirst($log) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2 mb-2">
                                <label for="event" class="mr-2">Event</label>
                                <select name="event" id="event" class="form-control">
                                    <option value="all">All</option>
                                    @foreach(\Spatie\Activitylog\Models\Activity::distinct('event')->pluck('event') as $event)
                                        @if($event)
                                            <option value="{{ $event }}">{{ ucfirst($event) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
                        </form>
                        <div class="table-responsive">
                            <table id="activity-table" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Subject</th>
                                        <th>Details</th>
                                        <th>Date</th>
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
            var table = $('#activity-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('activity.index') }}',
                    data: function (d) {
                        d.user_id = $('#user_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.log_name = $('#log_name').val();
                        d.event = $('#event').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user', name: 'user', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'subject', name: 'subject', orderable: false, searchable: false },
                    { data: 'details', name: 'details', orderable: false, searchable: false },
                    { data: 'date', name: 'date' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
            });

            $('#activity-filter-form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });
        });
    </script>
@endpush