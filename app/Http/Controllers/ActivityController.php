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
            $query = Activity::with(['causer', 'subject'])->select(['id', 'causer_id', 'causer_type', 'subject_id', 'subject_type', 'description', 'event', 'created_at']);
            return DataTables::of($query)
                ->addColumn('causer', function ($activity) {
                    return $activity->causer ? ($activity->causer->name ?? $activity->causer->email ?? '-') : '-';
                })
                ->addColumn('subject', function ($activity) {
                    return $activity->subject ? class_basename($activity->subject_type) . ' #' . $activity->subject_id : '-';
                })
                ->editColumn('created_at', function ($activity) {
                    return optional($activity->created_at)->format('M d, Y H:i');
                })
                ->rawColumns(['causer', 'subject'])
                ->make(true);
        }
        return view('activity.index');
    }
}
