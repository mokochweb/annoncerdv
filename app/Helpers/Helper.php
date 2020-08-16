<?php
namespace App\Helpers; 
use App\PostsMessages;
use Illuminate\Support\Facades\Auth;

class Helper{
    public static function get_unread_message_count()
    {
        $user_id =  Auth::id();
        return PostsMessages::where("to_user_id","$user_id")
        ->whereRaw("(seen_by IS null or seen_by not like '%$user_id%')")->count();
    }
}