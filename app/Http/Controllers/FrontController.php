<?php

namespace App\Http\Controllers;

use App\Field;
use Gate;
use App\Base;
use App\Unit;
use App\User;
use Carbon\Carbon;
use App\Unit_user;
use App\Recruit_user;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $base = Base::where('user_id', $user->id)->first();

        return view('front.home', compact('base'));
    }

    public function units()
    {
        $user = Auth::user();
        $unit_user = Unit_user::where('user_id', $user->id)->get();

        return view('front.units', compact('unit_user'));
    }

    public function recruits()
    {
        $user = Auth::user();
        $units = Unit::all();
        $recruits = Recruit_user::where('user_id', $user->id)->get();

        return view('front.recruits', compact('units', 'recruits'));
    }

    public function addRecruits(Request $request)
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

    public function builder()
    {
        return view('front.builder');
    }

    public function research()
    {
        return view('front.research');
    }

    public function resources()
    {
        $user = Auth::user();
        $fields = Field::where('user_id', $user->id)->first();

        return view('front.resources', compact('fields', 'user'));
    }

    public function setResources(Request $request)
    {
        $user = Auth::user();
        $peon = Unit_user::where(['user_id' => $user->id, 'unit_id' => 1])->first();

        $peon = $peon ? $peon->units : 0;

        $fields = Field::where('user_id', $user->id)->first();

        if ($request->get('units') > $peon)
            return back()->with('error', 'Vous n\'avez pas autant d\'ouvrier dans votre armée !');

        if ($request->get('units') > $fields->fields)
            return back()->with('error', 'Vous ne pouvez pas avoir plus d\'ouvrier que de km² de territoire !');

        $fields->units = $request->get('units');
        $fields->touch();

        return back()->with('success', 'Vos ouvriers ont été réattribué à la tache !');

    }

    public function field()
    {
        return view('front.field');
    }

    public function map()
    {
        return view('front.map');
    }

    public function help()
    {
        return view('front.help');
    }
}
