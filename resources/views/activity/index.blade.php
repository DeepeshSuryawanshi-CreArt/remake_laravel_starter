@extends('layouts.app')

@push('title') Activity Log @endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('breadcrumb')
    <li class="breadcrumb-item active">Activity Log</li>
@endpush

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
                    <div class="table-responsive">
                        <table id="activity-table" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Causer</th>
                                    <th>Event</th>
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Created At</th>
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
        $('#activity-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('activity.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'causer', name: 'causer' },
                { data: 'event', name: 'event' },
                { data: 'subject', name: 'subject' },
                { data: 'description', name: 'description' },
                { data: 'created_at', name: 'created_at' },
            ],
            order: [[0, 'desc']],
        });
    });
</script>
@endpush
