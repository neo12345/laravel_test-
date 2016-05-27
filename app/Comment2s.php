<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment2s extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'comment',
        'chapter_id',
        'reply_to',
    ];
    
        //Dinh nghia quan he voi chapter
    public function chapter()
    {
        return $this->belongsTo(
                'App\Chapters', 'chapter_id'
        );
    }
    
    //Dinh nghia quan he voi comic
    public function users()
    {
        return $this->belongsTo(
                'App\User', 'user_id'
        );
    }
    
    //Dinh nghia quan he voi comment
    public function comments()
    {
        return $this->belongsTo('App\Comment2s', 'reply_to');
    }
    
    public function replies()
    {
        return $this->hasMany('App\Comment2s', 'reply_to');
    }
}
