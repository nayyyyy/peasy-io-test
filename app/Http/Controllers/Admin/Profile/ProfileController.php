<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile\Profile;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class ProfileController extends Controller
{
    /**
     * @throws Throwable
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $profile = Profile::findOrFail($id);

            DB::transaction(fn()=> $profile->delete());

            toastr()->success('Delete success!');
        } catch (Throwable $throwable){
            toastr()->error($throwable->getMessage());
        }

        return redirect()->back();
    }
}
