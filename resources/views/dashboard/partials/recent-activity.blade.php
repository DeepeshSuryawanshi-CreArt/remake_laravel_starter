@php
use Spatie\Activitylog\Models\Activity;
$recentActivities = Activity::with('causer')->latest()->limit(5)->get();
@endphp
<div class="card card-shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="icon md-history mr-2" aria-hidden="true"></i>Recent Activity
        </h5>
    </div>
    <div class="card-body p-0">
        @forelse($recentActivities as $activity)
            <div class="list-group-item border-bottom p-15">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="font-weight-600 text-dark mb-5">
                            {{ $activity->causer ? ($activity->causer->name ?? $activity->causer->email ?? '-') : 'System' }}
                        </div>
                        <div class="text-muted small">
                            {{ $activity->description }}
                        </div>
                    </div>
                    <div class="text-muted small text-nowrap ml-15">
                        {{ $activity->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item text-muted text-center py-30">
                <i class="icon md-info-outline font-size-24 mb-10"></i>
                <div>No recent activity found.</div>
            </div>
        @endforelse
    </div>
    <div class="card-footer text-center p-15 bg-light">
        <a href="{{ route('activity.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="icon md-open-in-new mr-5" aria-hidden="true"></i>View All Activity
        </a>
    </div>
</div>
