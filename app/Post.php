<?php


namespace App;


use App\Setting;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewPostNotification;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
    protected $table = 'posts' ;
    protected $primaryKey = 'id' ;
    protected $guarded = ['id'];
     
    //protected $fillable = [ 'titre' , 'qte' , 'daterdvbegin' , 'daterdvend' , 'Hbeginrdv' , 'Hendrdv' , 'adresse'];

    protected static function booted()
    {
        static::created( function ($post) {
            
            $settings = Setting::where('user_id', '!=', $post->user_id)->get();
            foreach($settings as $setting)
            {
                $setting->user->notify(new NewPostNotification);
            }
        });
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function messages()
    {
        $user_id =  Auth::id();
                return $this->hasMany('App\PostsMessages', 'post_id', 'id')->whereRaw("to_user_id = $user_id OR from_user_id = $user_id");
    }
}
