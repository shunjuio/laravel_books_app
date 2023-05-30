<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'book_id'  => 'required',
            'start_at' => 'required|date|after_or_equal:today',
            'end_at'   => 'required|date|after_or_equal:start_at|before_or_equal:' . $this->getEndDateLimit(),
        ];
    }

    private function getEndDateLimit()
    {
        //終了日を開始日から7日以内とするためのメソッド
        $startDate = Carbon::parse($this->input('start_at'));
        return $startDate->copy()->addDays(7)->format('Y-m-d');
    }

    public function after(): array
    {
        $book_id  = $this->request->get('book_id');
        $start_at = $this->request->get('start_at');
        $end_at   = $this->request->get('end_at');
        $isReservationExists = Reservation::where('book_id', $book_id)
                           ->whereHasReservation($start_at, $end_at)
                           ->exists();

        return [
            function (Validator $validator) use($isReservationExists) {
                if ($isReservationExists) {
                    $validator->errors()->add(
                        'date_range',
                        'すでに予約が入っています。他の日付を選択してください。'
                    );
                }
            }
        ];
    }
}
