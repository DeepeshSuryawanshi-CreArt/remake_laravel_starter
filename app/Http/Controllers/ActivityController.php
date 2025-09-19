<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Activity::with(['causer', 'subject'])->select(['id', 'causer_id', 'causer_type', 'subject_id', 'subject_type', 'description', 'event', 'log_name', 'created_at']);

            // User filter (admin-like roles)
            if ($request->filled('user_id')) {
                $query->where('causer_id', $request->input('user_id'));
            }

            // Date range filter
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->input('from_date'));
            }
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->input('to_date'));
            }

            // Log name filter
            if ($request->filled('log_name') && $request->input('log_name') !== 'all') {
                $query->where('log_name', $request->input('log_name'));
            }

            // Event filter
            if ($request->filled('event') && $request->input('event') !== 'all') {
                $query->where('event', $request->input('event'));
            }

            return DataTables::of($query)
                ->addColumn('user', function ($activity) {
                    // Avatar initials (e.g. SA) and name
                    $name = $activity->causer ? ($activity->causer->name ?? $activity->causer->email ?? '-') : 'System';
                    $initials = collect(explode(' ', $name))->map(fn($w) => mb_substr($w, 0, 1))->implode('');
                    $avatar = '<span class="avatar avatar-sm avatar-online mr-1" style="background:#f5f6fa;color:#6c63ff;font-weight:600;">' . e($initials ?: 'SA') . '</span>';
                    return $avatar . ' <span style="font-weight:500">' . e($name) . '</span>';
                })
                ->addColumn('action', function ($activity) {
                    $event = strtolower($activity->event);
                    $map = [
                        'created' => ['Created', 'success'],
                        'updated' => ['Updated', 'warning'],
                        'assigned' => ['Assigned', 'info'],
                        'deleted' => ['Deleted', 'danger'],
                    ];
                    $label = $map[$event][0] ?? ucfirst($activity->event);
                    $color = $map[$event][1] ?? 'secondary';
                    return '<span class="badge badge-' . $color . '">' . $label . '</span>';
                })
                ->addColumn('subject', function ($activity) {
                    if ($activity->subject) {
                        $type = class_basename($activity->subject_type);
                        return '<b>' . $type . ' #' . $activity->subject_id . '</b>';
                    }
                    return '-';
                })
                ->addColumn('details', function ($activity) {
                    return e($activity->description);
                })
                ->addColumn('date', function ($activity) {
                    return optional($activity->created_at)->format('M d, Y H:i');
                })
                ->addColumn('actions', function ($activity) {
                    $url = route('activity.show', $activity->id);
                    return '<a href="' . $url . '" class="btn btn-sm btn-info" title="View"><i class="icon md-eye"></i></a>';
                })
                ->rawColumns(['user', 'action', 'subject', 'actions'])
                ->orderColumn('date', 'created_at $1')
                ->make(true);
        }
        return view('activity.index');
    }

    /**
     * Display the specified activity log entry.
     */
    public function show($id)
    {
        $activity = \Spatie\Activitylog\Models\Activity::with(['causer', 'subject'])->findOrFail($id);
        $properties = $activity->properties ? $activity->properties->toArray() : [];
        $old = $properties['old'] ?? [];
        $new = $properties['attributes'] ?? [];
        return view('activity.show', compact('activity', 'old', 'new'));
    }
}
