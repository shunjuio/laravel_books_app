<h2>Reservations/index</h2>
<h1>予約している本一覧</h1>

@if($reservations->isEmpty())
    <h3>現在予約している本はありません</h3>
@else
<div>
    @foreach($reservations as $reservation)
      <div>
          <img src="{{ 'storage/'. $reservation->book->image_path}}" style='max-width:250px;max-height:400px'>
          <p><a href="{{ route('reservations.show', ['reservationId'=> $reservation->id] )}}"><span>{{ $reservation->book->title }}</span></a></p>
          <p>{{\Carbon\Carbon::parse($reservation->start_at)->format('Y年m月d日')}}から</p>
      </div>
    @endforeach
</div>
@endif
