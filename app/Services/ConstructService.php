<?php

namespace App\Services;

use Carbon\Carbon;
use App\Building;
use App\Building_user;
use Illuminate\Support\Facades\Auth;

class ConstructService
{

    public static function building($user)
    {
        foreach (Building_user::where(['user_id' => $user->id, 'built' => 0])->get() as $built) {
            if (Carbon::now() >= $built->finished_at) {
                $built->built = 1;
                $built->touch();
            }
        }
    }

    public static function built($id)
    {
        $user = Auth::user();
        $building = Building::find($id);
        $resource = $building->wood;

        if ($user->wood < $resource)
            return back()->with('error', 'Vous n\'avez pas assez de bois pour construire ce bâtiment !');

        $lastBuilt = Building_user::where(['user_id' => $user->id, 'built' => 0])->orderBy('finished_at', 'DESC')->first();

        if ($lastBuilt)
            $finishedAt = $lastBuilt->finished_at;
        else
            $finishedAt = Carbon::now();

        $time = $building->time;
        Building_user::create([
            'building_id' => $building->id,
            'user_id' => $user->id,
            'finished_at' => $finishedAt->addSeconds($time),
        ]);

        $user->wood = $user->wood - $resource;
        $user->touch();

        return back()->with('success', 'Votre bâtiment est en cours de construction...');
    }

}