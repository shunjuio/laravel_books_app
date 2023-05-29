<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

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
}
