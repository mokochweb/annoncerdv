<?php


namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class News extends Authenticatable
{
    use Notifiable ;
    protected $primaryKey = ['id'];
    protected $table = 'news' ;
    protected $fillable = ['news' , 'content_news'];
}
