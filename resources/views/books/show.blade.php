@vite(['resources/js/form.js'])

<h3>Title:{{$book->title}}</h3>
<img src="{{ asset($book->image_path)}}" style='max-width:500px;max-height:500px'>
<br>

@if($isLending)
    <p>貸出中</p>
    <p>{{\Carbon\Carbon::parse($book->nowlending->end_at)->addDays()->format('Y年m月d日')}}　から貸出・予約可能です</p>
@else
    <p>貸出可能</p>
@endif

<div>
    <input id="input_start_at" name="start_at" type="date" min="{{$book->default_date}}" value="{{$book->default_date}}"> から
    <input id="input_end_at" name="end_at" type="date" min="{{$book->default_date}}" value="{{$book->default_date}}"> まで
</div>

<div class="submit_form_box" style="display: flex; margin-top: 15px; column-gap: 15px;">
    <form action="{{ route('lendings.store') }}" method="POST">
        @csrf
        <input name="book_id" type="hidden" value="{{$book->id}}">
        <input id="lending_start_at" name="start_at" type="hidden">
        <input id="lending_end_at" name="end_at" type="hidden">
        <input id="submit_lending" type="submit" value="借りる" {{ $isLending ? 'disabled' : '' }}>
    </form>
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input name="book_id" type="hidden" value="{{$book->id}}">
        <input id="reservation_start_at" name="start_at" type="hidden">
        <input id="reservation_end_at" name="end_at" type="hidden">
        <input id="submit_reservation" type="submit" value="予約する">
    </form>
</div>
