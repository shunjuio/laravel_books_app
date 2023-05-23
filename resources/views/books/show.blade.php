<h3>Title:{{$book->title}}</h3>
<img src="{{ asset($book->image_path)}}" style='max-width:500px;max-height:500px'>
<br>

@if($isLending)
    <p>貸出中</p>
    <p>{{\Carbon\Carbon::parse($book->nowlending->end_at)->addDays()->format('Y年m月d日')}}　から貸出・予約可能です</p>
@else
    <p>貸出可能</p>
@endif

<form action="{{ route('lendings.store') }}" method="POST">
    @csrf
    <input name="book_id" type="hidden" value="{{$book->id}}">
    <input name="start_at" type="date"> から
    <br>
    <input name="end_at" type="date"> まで
    <br>
    <input type="submit" value="借りる" {{ $isLending ? 'disabled' : '' }}>
</form>

<h2>Reservation</h2>
<form action="{{ route('reservations.store') }}" method="POST">
  @csrf
  <input name="book_id" type="hidden" value="{{$book->id}}">
  <input name="start_at" type="date"> から
  <br>
  <input name="end_at" type="date"> まで
  <br>
  <input type="submit" value="予約する">
</form>


@if($book->reservations->isEmpty())
    <p>予約はありません</p>
@else
    @foreach($book->reservations as $reservation)
        <p>{{$reservation->start_at}} - {{$reservation->end_at}} </p>
    @endforeach

@endif
