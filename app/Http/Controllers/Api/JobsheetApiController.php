<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobsheet;
use App\Models\LogJobsheet;

class JobsheetApiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $jobsheets = Jobsheet::all()->map(function ($jobsheet) use ($userId) {
            $log = LogJobsheet::where('jobsheet_id', $jobsheet->id)
                              ->where('user_id', $userId)
                              ->first();

            return [
                'id' => $jobsheet->id,
                'title' => $jobsheet->title,
                'description' => $jobsheet->description,
                'duration' => $jobsheet->duration,
                'status' => $log ? ($log->nilai !== null ? 'Sudah dinilai' : 'Sudah dikumpulkan') : 'Belum dikumpulkan',
                'nilai' => $log->nilai,
                'link_pdf' => $log->link_pdf ?? null,
            ];
        });

        return response()->json([
            'message' => 'Jobsheet list with user status.',
            'data' => $jobsheets
        ]);
    }

    public function show($id)
    {
        $userId = Auth::id();
        $jobsheet = Jobsheet::findOrFail($id);

        $log = LogJobsheet::where('jobsheet_id', $id)
                          ->where('user_id', $userId)
                          ->first();

        return response()->json([
            'id' => $jobsheet->id,
            'title' => $jobsheet->title,
            'description' => $jobsheet->description,
            'duration' => $jobsheet->duration,
            'status' => $log ? ($log->nilai !== null ? 'Sudah dinilai' : 'Sudah dikumpulkan') : 'Belum dikumpulkan',
            'nilai' => $log->nilai,
            'link_pdf' => $log->link_pdf ?? null,
        ]);
    }
}