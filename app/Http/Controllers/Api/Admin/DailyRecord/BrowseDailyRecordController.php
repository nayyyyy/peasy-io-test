<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\DailyRecord;

use App\Http\Controllers\Controller;
use App\Models\Record\DailyRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class BrowseDailyRecordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $query = DailyRecord::query();

            return DataTables::eloquent($query)->toJson(JSON_PRETTY_PRINT);
        } catch (Throwable $throwable) {
            return response()->json([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $throwable->getMessage(),
            ]);
        }
    }
}
