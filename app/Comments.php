<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'comment',
        'comic_id',
        'reply_to',
    ];
    
    //Dinh nghia quan he voi comic
    public function comics()
    {
        return $this->belongsTo(
                'App\Comics', 'comic_id'
        );
    }
    
    //Dinh nghia quan he voi user
    public function users()
    {
        return $this->belongsTo(
                'App\User', 'user_id'
        );
    }

//    //Dinh nghia quan he voi chapter
//    public function chapters()
//    {
//        return $this->belongsTo('App\Chapters', 'pivot_chapter_comments', 'comment_id', 'chapter_id');
//    }
    
    //Dinh nghia quan he voi comment
    public function comments()
    {
        return $this->belongsTo('App\Comments', 'reply_to');
    }
    
    public function replies()
    {
        return $this->hasMany('App\Comments', 'reply_to');
    }
    
    //Xoa tat car cac thu co lien quan truoc khi xoa
    public static function boot()
    {
        parent::boot();

        static::deleted(function($comment) {
            foreach ($comment->replies as $reply) {
                $reply->replies()->delete();
            }
            $comment->replies()->delete();
        });
    }
}
