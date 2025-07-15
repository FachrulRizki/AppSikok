<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasRole('Super Admin')) return abort(403);

        $start = $request->get('start');
        $end = $request->get('end');
        $event = $request->get('event');

        $data = Activity::with('causer');

        if ($start && $end) {
            $data = $data->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end);
        }

        if ($event) {
            $data = $data->where('event', $event);
        }

        $data = $data->latest()->paginate(10);

        $availableEvents = DB::table('activity_log')
            ->selectRaw('event')
            ->groupBy('event')
            ->get();

        return view('activity_log.index', compact('data', 'availableEvents'));
    }
}
