<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

final class DashboardController extends Controller
{
    public function index(): View|Application|Factory
    {
        $data = [
            'maleCount' => Cache::get('male_count') ?? 0,
            'femaleCount' => Cache::get('female_count') ?? 0,
            'total' => array_sum([Cache::get('male_count') ?? 0, Cache::get('female_count') ?? 0])
        ];

        return view('admin.pages.dashboard', $data);
    }
}
