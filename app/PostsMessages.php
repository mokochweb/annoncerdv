<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class PostsMessages extends Model
{
    protected $table = 'posts_messages' ;
    protected $primaryKey = 'id' ;
    protected $guarded = [ 'id'];

     const REPLY_CLASS = 'replies';

     const SENT_CLASS = 'sent';


    public function from_user()
    {
        return $this->hasOne('App\User', 'id', 'from_user_id');
    }

    public function to_user()
    {
        return $this->hasOne('App\User', 'id', 'to_user_id');
    }

    public function post()
    {
        return $this->hasOne('App\Post', 'id', 'post_id');
    }

    public function getLastMessageAttribute()
    {
        $last_message = $this->where('from_user_id', $this->from_user_id)->orderBy('id', 'desc')->first();
        return !is_null($last_message) ? $last_message->message : '';
    }
}
