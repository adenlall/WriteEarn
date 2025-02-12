<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'expert',
        'content',
        'blog_id',
    ];

    public function blog(): BelongsTo
    {
        return $this->BelongsTo(Blog::class);
    }
}
