<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $table = 'tags';
    protected $fillable = [
        'tag',
        'title',
        'subtitle',
        'page_image',
        'meta_description',
        'layout',
        'reverse_direction',
    ];

    /**
     * 
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\BlogPosts', 'post_tag_pivot');
    }

    public static function addNeededTags(array $tags)
    {
        if (count($tags) == 0) {
            return;
        }

        $found = static::whereIn('tag', $tags)->lists('tag')->all();

        foreach (array_diff($tags, $found) as $tag) {
            static::create([
                'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for ' . $tag,
                'page_image' => '',
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
    }
}
