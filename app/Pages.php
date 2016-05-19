<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    //Chi duoc dien vao 2 thuoc tinh
    protected $fillable = [
        'link',
        'chapter_id'
    ];
    
    //Dinh nghia quan he
    public function chapters(){
        return $this->belongsTo('App\Chapters', 'chapter_id');
    }
}
