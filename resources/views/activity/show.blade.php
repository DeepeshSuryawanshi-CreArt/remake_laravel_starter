@extends('layouts.app')

@push('title') Activity Log Details @endpush
@section('body-class', 'animsition dashboard site-menubar-unfold')
@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('activity.index') }}">Activity Log</a></li>
    <li class="breadcrumb-item active">Details</li>
@endpush

@push('page-title')
    Activity Log Details
@endpush

@section('content')
<div class="page-content container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="panel panel-primary panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">Activity Log Details</h3>
                </div>
                <div class="panel-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $activity->id }}</dd>

                        <dt class="col-sm-4">User</dt>
                        <dd class="col-sm-8">
                            @if($activity->causer)
                                {{ $activity->causer->name ?? $activity->causer->email ?? 'System' }}
                            @else
                                System
                            @endif
                        </dd>

                        <dt class="col-sm-4">Action</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{
                                $activity->event === 'created' ? 'success' :
                                ($activity->event === 'updated' ? 'warning' :
                                ($activity->event === 'assigned' ? 'info' :
                                ($activity->event === 'deleted' ? 'danger' : 'secondary')))
                            }}">
                                {{ ucfirst($activity->event) }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Subject</dt>
                        <dd class="col-sm-8">
                            @if($activity->subject)
                                <b>{{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}</b>
                            @else
                                -
                            @endif
                        </dd>

                        <dt class="col-sm-4">Details</dt>
                        <dd class="col-sm-8">{{ $activity->description }}</dd>

                        <dt class="col-sm-4">Log Name</dt>
                        <dd class="col-sm-8">{{ $activity->log_name }}</dd>

                        <dt class="col-sm-4">Date</dt>
                        <dd class="col-sm-8">{{ $activity->created_at ? $activity->created_at->format('M d, Y H:i') : '-' }}</dd>
                    </dl>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
            @if(!empty($old) || !empty($new))
            <div class="panel panel-primary panel-line mt-4">
                <div class="panel-heading">
                    <h4 class="panel-title">Changes</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Field</th>
                                    <th style="width: 40%">Old</th>
                                    <th style="width: 40%">New</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $allKeys = array_unique(array_merge(array_keys($old ?? []), array_keys($new ?? [])));
                                @endphp
                                @forelse($allKeys as $key)
                                    <tr>
                                        <td><span style="color:#e83e8c">{{ $key }}</span></td>
                                        <td>{{ array_key_exists($key, $old) ? $old[$key] : '' }}</td>
                                        <td>
                                            {{ array_key_exists($key, $new) ? $new[$key] : '' }}
                                            @if(array_key_exists($key, $old) && array_key_exists($key, $new) && $old[$key] != $new[$key])
                                                <span class="badge badge-success ml-2">changed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No changes</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
