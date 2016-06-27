<?php

namespace App\Http\Controllers;

use App\Message;
use App\Services\RecruitService;
use Gate;
use App\Base;
use App\Unit;
use App\Field;
use App\Building;
use Carbon\Carbon;
use App\Unit_user;
use App\Recruit_user;
use App\Building_user;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\FightService;
use App\Services\ConstructService;
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

    public function addRecruits(Requests\RecruitRequest $request)
    {
        return RecruitService::addRecruits($request);
    }

    public function builder()
    {

        $user = Auth::user();
        $buildings = Building::all();
        $user_building = $user->buildings();
        $builts = $user->buildings()->where('built', 0)->get();

        return view('front.builder', compact('user', 'buildings', 'user_building', 'builts'));
    }

    public function built($id)
    {
        return ConstructService::built($id);
    }

    public function research()
    {
        $user = Auth::user();
        return view('front.research');
    }

    public function resources()
    {
        $user = Auth::user();
        $fields = Field::where('user_id', $user->id)->first();

        return view('front.resources', compact('fields', 'user'));
    }

    public function setResources(Requests\FieldRequest $request)
    {
        $user = Auth::user();
        $peon = Unit_user::where(['user_id' => $user->id, 'unit_id' => 1])->first();

        $peon = $peon ? $peon->units : 0;

        $fields = Field::where('user_id', $user->id)->first();
        $units_banana = $request->get('units_banana');
        $units_wood = $request->get('units_wood');

        if (($units_banana + $units_wood) > $peon)
            return back()->with('error', 'Vous n\'avez pas autant d\'ouvrier dans votre armée !');

        if (($units_banana + $units_wood) > $fields->fields)
            return back()->with('error', 'Vous ne pouvez pas avoir plus d\'ouvrier que de km² de territoire !');

        $fields->units_banana = $units_banana;
        $fields->units_wood = $units_wood;
        $fields->touch();

        return back()->with('success', 'Vos ouvriers ont été réattribué à la tache !');

    }

    public function field()
    {
        $user = Auth::user();
        return view('front.field');
    }

    public function map()
    {
        $user = Auth::user();
        $bases = Base::where('user_id', '!=', $user->id)->get();

        return view('front.map', compact('bases'));
    }

    public function loot(Base $base)
    {
        $user = Auth::user();
        $enemy = $base->user;

        return FightService::fight($user, $enemy);

        //return back()->with('success', 'Vous lancer votre armée sur le bananier de ' . $base->user->name . ' et tentez de le piller !');
    }

    public function help()
    {
        $user = Auth::user();
        return view('front.help');
    }

    public function messages()
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)->get();

        return view('front.messages', compact('messages'));
    }

    public function message(Message $message)
    {
        $message->read = 1;
        $message->touch();

        return view('front.message', compact('message'));
    }
}
