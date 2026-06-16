<?php

namespace App\Http\Controllers;

use App\Models\ContaminationLog;
use Illuminate\Http\Request;

class ContaminationController extends Controller
{
    public function index()
    {
        $logs = ContaminationLog::with(['sensorDevice', 'foodCategory', 'sensorReading'])
            ->latest('detected_at')
            ->paginate(15);

        $totalDetected = ContaminationLog::where('status', 'terdeteksi')->count();
        $totalInvestigating = ContaminationLog::where('status', 'investigasi')->count();
        $totalResolved = ContaminationLog::where('status', 'teratasi')->count();
        $totalCritical = ContaminationLog::where('severity', 'kritis')->where('status', '!=', 'teratasi')->count();

        return view('admin.contamination.index', compact('logs', 'totalDetected', 'totalInvestigating', 'totalResolved', 'totalCritical'));
    }

    public function updateStatus(Request $request, ContaminationLog $log)
    {
        $request->validate([
            'status' => 'required|in:terdeteksi,investigasi,teratasi',
        ]);

        $log->update([
            'status' => $request->status,
            'resolved_at' => $request->status === 'teratasi' ? now() : null,
        ]);

        return redirect()->route('admin.contamination.index')->with('success', 'Status log kontaminasi berhasil diperbarui.');
    }

    public function destroy(ContaminationLog $log)
    {
        if ($log->sensor_reading_id) {
            \App\Models\SensorReading::where('id', $log->sensor_reading_id)->delete();
        }
        $log->delete();
        return redirect()->route('admin.contamination.index')->with('success', 'Log kontaminasi dan data sensor terkait berhasil dihapus.');
    }

    public function clearAll()
    {
        $readingIds = ContaminationLog::whereNotNull('sensor_reading_id')->pluck('sensor_reading_id');
        ContaminationLog::query()->delete();
        if ($readingIds->isNotEmpty()) {
            \App\Models\SensorReading::whereIn('id', $readingIds)->delete();
        }
        return redirect()->route('admin.contamination.index')->with('success', 'Seluruh riwayat log kontaminasi dan data sensor terkait berhasil dihapus.');
    }
}
