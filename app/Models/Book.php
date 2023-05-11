<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = [
        'title',
        'image_path',
    ];

    protected $table = 'books';

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_book', 'book_id', 'tag_id');
    }
}
