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
    //khi co thay doi se thay doi updated_at cua
    protected $touches = [];

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

    //Xoa tat car cac thu cos lien quan truoc khi xoa
    public static function boot()
    {
        parent::boot();

        static::deleted(function($comic) {
            $comic->chapters()->delete();
            $comic->categories()->detach();
        });
    }
}
