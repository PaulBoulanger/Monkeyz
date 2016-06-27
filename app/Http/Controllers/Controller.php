<?php

namespace App\Http\Controllers;

use View;
use App\Unit_user;
use Carbon\Carbon;
use App\Services\ConstructService;
use App\Services\RecruitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

        Carbon::setLocale(env('LOCALE', 'en'));

        if (Auth::check()) {
            $user = Auth::user();
            $user->getIncome();

            RecruitService::recruting($user);
            ConstructService::building($user);

            View::composer('*', function ($view) {
                $user = Auth::user();
                if ($peons = Unit_user::where(['unit_id' => 1, 'user_id' => $user->id])->first())
                    $peons = $peons->units;
                else
                    $peons = 0;

                $view->with(compact('user', 'peons'));
            });
        }
    }
}
