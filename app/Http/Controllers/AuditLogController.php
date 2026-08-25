<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Auth;

class AuditLogController extends Controller
{
    /**
     * Display all audit logs (Admin only)
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->byAction($request->action);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->byUser($request->user_id);
        }

        // Filter by model type
        if ($request->has('model_type') && $request->model_type) {
            $query->byModel($request->model_type);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);
        $users = \App\Models\User::select('id', 'name')->get();

        return view('admin.audit-logs.index', compact('logs', 'users'));
    }

    /**
     * Display audit logs for a specific model
     */
    public function modelLogs(string $modelType, int $modelId)
    {
        $logs = AuditLog::where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('admin.audit-logs.model', compact('logs', 'modelType', 'modelId'));
    }

    /**
     * Display audit logs for a specific user
     */
    public function userLogs($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $logs = $user->auditLogs()
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.audit-logs.user', compact('user', 'logs'));
    }

    /**
     * Display a single audit log entry
     */
    public function show(AuditLog $auditLog)
    {
        return view('admin.audit-logs.show', compact('auditLog'));
    }

    /**
     * Export audit logs to CSV
     */
    public function export(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->has('action') && $request->action) {
            $query->byAction($request->action);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->byUser($request->user_id);
        }

        if ($request->has('model_type') && $request->model_type) {
            $query->byModel($request->model_type);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        $csv = "ID,Date,User,Action,Model Type,Model ID,Description,IP Address\n";
        foreach ($logs as $log) {
            $csv .= sprintf(
                "%d,%s,\"%s\",\"%s\",%s,%s,\"%s\",%s\n",
                $log->id,
                $log->created_at->format('Y-m-d H:i:s'),
                $log->user->name ?? 'Unknown',
                $log->getActionLabel(),
                $log->model_type ?? 'N/A',
                $log->model_id ?? 'N/A',
                str_replace('"', '""', $log->description),
                $log->ip_address ?? 'N/A'
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="audit_logs_' . now()->format('Y-m-d') . '.csv"');
    }

    /**
     * Delete old audit logs (cleanup)
     */
    public function cleanup(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $deleted = AuditLog::where('created_at', '<', now()->subDays($request->days))->delete();

        return response()->json([
            'success' => true,
            'message' => "Deleted $deleted old audit log entries",
        ]);
    }
}
