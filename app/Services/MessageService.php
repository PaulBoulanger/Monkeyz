<?php

namespace App\Services;


use App\Message;

class MessageService
{

    public static function sendMessage($user, $enemy, $bananas, $field, $dead, $status)
    {

        $message = Message::create([
            'user_id' => $user->id,
        ]);

        if ($status === 'win')
            $message->message = "<p>Vous avez gagné la bataille contre $enemy->name, vous avez récolté $bananas bananes, $field km² de terrain</p><p>Vous avez perdu $dead% de votre armée.</p>";
        else
            $message->message = "<p>Vous avez perdu la bataille contre $enemy->name, vous avez perdu toute votre armée.</p>";

        $message->touch();


        $message = Message::create([
            'user_id' => $enemy->id,
        ]);

        if ($status === 'win')
            $message->message = "<p>Vous n'avez pas réussis à défendre contre $user->name, vous avez perdu toute votre armée et perdu la moitié de vos ressources, $bananas bananes, $field km² de terrain.</p>";
        else
            $message->message = "<p>Vous avez défendu contre $user->name.</p><p>Vous avez perdu $dead% de votre armée.</p>";

        $message->touch();
    }

}