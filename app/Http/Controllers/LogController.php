<?php

namespace App\Http\Controllers;

use App\Services\LogServiceSingleton;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogController extends Controller
{
    public function __construct(private LogServiceSingleton $logService) {}
    # GET /logs  
    public function index(): JsonResponse
    {
        $logs = array_reverse($this->logService->all()); // mais recentes primeiro
        return response()->json($logs);
    }

    
    # POST /logs
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'level'   => 'required|in:info,warn,error',
            'message' => 'required|string|max:2000',
        ]);

        match ($data['level']) {
            'info'  => $this->logService->info($data['message']),
            'warn'  => $this->logService->warn($data['message']),
            'error' => $this->logService->error($data['message']),
        };

        return response()->json(['ok' => true], 201);
    }
}
