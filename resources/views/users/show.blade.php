@extends('layouts.app')

@push('title') User Details @endpush

@section('body-class', 'animsition dashboard site-menubar-unfold')

@push('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Show</li>
@endpush

@push('page-title')
    User Details
@endpush

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-primary panel-line">
                    <div class="panel-heading d-flex justify-content-between align-items-center">
                        <h3 class="panel-title">User: {{ $user->name }}</h3>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm ml-2">
                            <i class="icon md-edit" aria-hidden="true"></i> Edit
                        </a>
                    </div>
                    <div class="panel-body">
                        <dl class="row">
                            <dt class="col-sm-3">Name</dt>
                            <dd class="col-sm-9">{{ $user->name }}</dd>
                            <dt class="col-sm-3">Email</dt>
                            <dd class="col-sm-9">{{ $user->email }}</dd>
                            <dt class="col-sm-3">Roles</dt>
                            <dd class="col-sm-9">{{ $user->roles->pluck('name')->join(', ') }}</dd>
                            <dt class="col-sm-3">Created At</dt>
                            <dd class="col-sm-9">{{ $user->created_at->format('M d, Y') }}</dd>
                        </dl>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-default">
                            <i class="icon md-arrow-left" aria-hidden="true"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
