<?php

namespace App\Rules;

use App\Models\Reservation;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class OverlapReservation implements DataAwareRule, ValidationRule
{
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $book_id  = $this->data['book_id'];
        $start_at = $this->data['start_at'];
        $end_at   = $this->data['end_at'];

        if (($start_at && $end_at) && $start_at <= $end_at) {
            $isReservationExists = Reservation::where('book_id', $book_id)
                ->whereHasReservation($start_at, $end_at)
                ->exists();
        } else {
            $isReservationExists = false;
        }
        if ($isReservationExists) {
            $fail('すでに予約が入っています。他の日付を選択してください。');
        }
    }

    public function setData(array $data) : static
    {
        $this->data = $data;

        return $this;
    }
}
