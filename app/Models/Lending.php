<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lending extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = [
        'user_id',
        'book_id',
        'start_at',
        'end_at',
        'is_returned',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
