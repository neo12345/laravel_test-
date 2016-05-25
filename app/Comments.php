<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'comment',
    ];
    
    //Dinh nghia quan he voi comic
    public function comics()
    {
        return $this->belongsTo(
                'App\Comics', 'pivot_comic_comments', 'comment_id', 'comic_id'
        );
    }

    //Dinh nghia quan he voi chapter
    public function chapters()
    {
        return $this->belongsTo('App\Chapters', 'pivot_chapter_comments', 'comment_id', 'chapter_id');
    }
    
    //Dinh nghia quan he voi comment
    public function comments()
    {
        return $this->belongsTo('App\Comments', 'pivot_comment_comments', 'reply_id', 'comment_id');
    }
    
    public function replies()
    {
        return $this->hasMany('App\Comments', 'pivot_comment_comments', 'comment_id', 'reply_id');
    }
}
