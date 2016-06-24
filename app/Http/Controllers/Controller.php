<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Unit_user;
use App\Recruit_user;
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
            View::composer('partials.info', function ($view) {
                $user = Auth::user();
                if ($peons = Unit_user::where(['unit_id' => 1, 'user_id' => $user->id])->first())
                    $peons = $peons->units;
                else
                    $peons = 0;

                $view->with(compact('user', 'peons'));
            });

            $now = Carbon::now();
            $lastIncome = $user->lastIncome;
            $hours = $now->diffInHours($lastIncome);
            if ($hours >= 1) {
                $user->lastIncome = $lastIncome->addHour($hours);
                $user->bananas += round($user->field->fields / 10) * $hours;
                $user->touch();
            }

        }
        foreach (Recruit_user::all() as $recruit) {
            if (Carbon::now() >= $recruit->finished_at) {
                $newUnit = Unit_user::firstOrCreate([
                    'unit_id' => $recruit->unit_id,
                    'user_id' => $recruit->user_id,
                ]);

                $newUnit->units = $newUnit->units + $recruit->units;
                $newUnit->touch();
                $recruit->delete();
            }
        }

    }
}
