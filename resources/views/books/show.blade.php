@vite(['resources/js/form.js'])
<script>
    const lendingAction = {{Js::from( route('lendings.store')) }};
    const reservationsAction = {{Js::from( route('reservations.store')) }};
</script>

<h3>Title:{{$book->title}}</h3>
<img src="{{ asset($book->image_path)}}" style='max-width:500px;max-height:500px'>
<br>

@if($isLending)
    <p>貸出中</p>
    <p>{{\Carbon\Carbon::parse($book->nowlending->end_at)->addDays()->format('Y年m月d日')}}　から貸出・予約可能です</p>
@else
    <p>貸出可能</p>
@endif

<form id="form" method="POST">
    @csrf
    <input name="book_id" type="hidden" value="{{$book->id}}">
    <input id="input_start_at" name="start_at" type="date" min="{{$book->default_date}}" value="{{$book->default_date}}"> から
    <input id="input_end_at" name="end_at" type="date" min="{{$book->default_date}}" value="{{$book->default_date}}"> まで
    <button id="lending_btn" type="button" {{ $isLending ? 'disabled' : '' }}>借りる</button>
    <button id="reservation_btn" type="button" >予約する</button>
</form>
