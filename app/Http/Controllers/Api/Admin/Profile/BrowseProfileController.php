<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

final class BrowseProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $query = Profile::query()
                ->latest('created_at');

            $request->whenFilled('name', function (string $name) use ($query): void {
                $query->whereRaw('LOWER(full_name) ILIKE ?', ['%' . mb_strtolower($name) . '%']);
            });

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
