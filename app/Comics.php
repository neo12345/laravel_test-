<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comics extends Model
{

    //chi cho phep dien 5 thuoc tinh
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'publish',
    ];

    //Dinh nghia quan he voi category
    public function categories()
    {
        return $this->belongsToMany(
                'App\Categories', 'pivot_comic_category', 'comic_id', 'category_id'
        );
    }

    //Dinh nghia quan he voi chapter
    public function chapters()
    {
        return $this->hasMany('App\Chapters', 'comic_id');
    }

    //Dinh nghia quan he voi comment
    public function comments()
    {
        return $this->hasMany('App\Comments', 'pivot_comic_comments', 'comic_id', 'comment_id');
    }

    //Xoa tat car cac thu co lien quan truoc khi xoa
    public static function boot()
    {
        parent::boot();

        static::deleted(function($comic) {
            foreach ($comic->chapters as $chapter) {
                $chapter->pages()->delete();
                foreach ($chapter->comments as $comment) {
                    $comment->replies()->delete();
                }
                $chapter->comments()->delete();
            }
            $comic->chapters()->delete();
            $comic->categories()->detach();
            foreach ($comic->comments as $comment) {
                $comment->replies()->delete();
            }
            $comic->comments()->delete();
        });
    }
}
