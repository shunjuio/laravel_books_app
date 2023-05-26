<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return tru3
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

    public function messages() : array
    {
        return [
            'start_at.required'       => ':attributeを選択して下さい。',
            'start_at.after_or_equal' => ':attributeは本日以降を選択して下さい。',
            'end_at.after_or_equal'   => ':attributeは開始日以降を選択して下さい。',
            'end_at.required'         => ':attributeを選択して下さい。',
            'end_at.before_or_equal'  => '貸出/予約期間は最大7日間です',
        ];
    }

    public function attributes() : array
    {
        return [
            'start_at' => '開始日',
            'end_at'   => '返却日',
        ];
    }

    private function getEndDateLimit()
    {
        //終了日を開始日から7日以内とするためのメソッド
        return $this->input('start_at') . ' +7days';
    }
}
