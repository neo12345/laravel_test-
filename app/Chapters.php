<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{

    //chi cho dien 3 thuoc tinh
    protected $fillable = [
        'name',
        'publish',
        'comic_id',
    ];
    
    //khi co thay doi se thay doi updated_at cua
    protected $touches = ['comics'];

    //Dinh nghia quan he voi comic
    public function comics()
    {
        return $this->belongsTo('App\Comics', 'comic_id');
    }

    //Dinh nghia quan he voi page
    public function pages()
    {
        return $this->hasMany('App\Pages', 'chapter_id');
    }
}
