<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LendingRequest extends FormRequest
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
    public function rules(Request $request) : array
    {
        return [
            'book_id'  => 'required|integer',
            'start_at' => 'required|date|after:yesterday',
            'end_at'   => 'required|date|after:start_at',
        ];
    }

    public function messages()
    {
        return [
            'start_at.required' => '貸出開始日は必須です',
            'start_at.after'    => '貸出開始日は本日以降で入力してください',
            'end_at.required'   => '貸出終了日は必須です',
            'end_at.after'      => '貸出終了日は貸出開始日以降を入力してください'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $bookId  = $this->request->get('book_id');
            $startAt = $this->request->get('start_at');
            $endAt   = $this->request->get('end_at');

            if (!empty($startAt) && !empty($endAt)) {
                $reservation = Reservation::where('book_id', $bookId)
                    ->whereHasReservation($startAt, $endAt)
                    ->doesntExist();
                if (!$reservation) {
                    $validator->errors()->add('date_range', 'すでに予約が入っています。他の日付を選択してください。');
                }
            }

        });
    }
}
