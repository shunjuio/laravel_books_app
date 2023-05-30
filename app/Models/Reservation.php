<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'book_id',
        'start_at',
        'end_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeWhereHasReservation(Builder $query, $start, $end)
    {
        $query->where(function ($q) use ($start, $end) {
            //チェックしたい日付の中から開始の予約がある
            $q->where('start_at', '>=', $start)
                ->where('start_at', '<=', $end);
        })
            ->orWhere(function ($q) use ($start, $end) {
                //チェックしたい日付の中で終わる予約がある
                $q->where('end_at', '>', $start)
                    ->where('end_at', '<=', $end);
            })
            ->orWhere(function ($q) use ($start, $end) {
                //チェックしたい日付の中に開始日と終了日が入る予約がある
                $q->where('start_at', '<', $start)
                    ->where('end_at', '>', $end);
            });
    }

}
