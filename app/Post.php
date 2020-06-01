<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'external_id', 'user_id'
    ];


    /**
     * Get the comments of the post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
