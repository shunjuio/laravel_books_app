@if($user)
  <h3>{{$user->name}}</h3>
@else
 <h3>名無し</h3>
@endif
<h2>Reservations/index</h2>
<h1>予約している本一覧</h1>
<div>
    @foreach($reservations as $reservation)
      <div>
          <img src="{{ 'storage/'. $reservation->book->image_path}}" style='max-width:250px;max-height:400px'>
          <p><a href="{{ route('reservations.show', ['reservationId'=> $reservation->id] )}}"><span>{{ $reservation->book->title }}</span></a></p>
          <p>{{\Carbon\Carbon::parse($reservation->start_at)->format('Y年m月d日')}}から</p>
      </div>
    @endforeach

</div>
