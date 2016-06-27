<?php

namespace App\Services;

use App\Unit;
use App\Unit_user;
use Carbon\Carbon;
use App\Recruit_user;
use Illuminate\Support\Facades\Auth;

class RecruitService
{
    public static function recruting($user)
    {
        $recruit = Recruit_user::where('user_id', $user->id)->first();
        if ($recruit) {
            $remaining = Carbon::now()->diffInSeconds($recruit->finished_at);
            $number = floor($recruit->units - $remaining / Unit::where('id', $recruit->unit_id)->first()->time);
            $newUnit = Unit_user::firstOrCreate([
                'unit_id' => $recruit->unit_id,
                'user_id' => $recruit->user_id,
            ]);

            $newUnit->units = $newUnit->units + $number;
            $newUnit->touch();

            $recruit->units = $recruit->units - $number;
            $recruit->touch();
        }

        foreach (Recruit_user::where('user_id', $user->id)->get() as $recruit) {

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

    public static function addRecruits($request)
    {
        $user = Auth::user();
        $number = $request->get('number');
        $unit = Unit::find($request->get('unit'));

        $resource = $unit->bananas * $number;

        if ($user->bananas < $resource)
            return back()->with('error', 'Vous n\'avez pas assez de bananes pour cet entraînement !');

        $lastRecruit = Recruit_user::where('user_id', $user->id)->orderBy('finished_at', 'DESC')->first();

        if ($lastRecruit)
            $finishedAt = $lastRecruit->finished_at;
        else
            $finishedAt = Carbon::now();

        $time = $unit->time * $number;
        Recruit_user::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'units' => $number,
            'finished_at' => $finishedAt->addSeconds($time),
        ]);

        $user->bananas = $user->bananas - $resource;
        $user->touch();

        return back()->with('success', 'Vos nouvelles recrut sont en cours d\'entraînement...');
    }
}