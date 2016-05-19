<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

    //Chi cho phep dien cac thuoc tinh
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    //Dinh nghia quan he voi comic
    public function comics()
    {
        return $this->belongsToMany(
                'App\Comics', 'pivot_comic_category', 'category_id', 'comic_id'
        );
    }

    //Xoa tat car moi thu lien quan truoc khi xoa
    public static function boot()
    {
        parent::boot();

        static::deleted(function($category) {
            $category->comics()->detach();
        });
    }
}
