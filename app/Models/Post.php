<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'image_url'];


    /**
     * Relations to eager load
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Get the user for the blog post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
