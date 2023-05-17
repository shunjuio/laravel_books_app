<h2><a href="/reservations" style="text-decoration: none;">予約している本一覧</a> > {{$reservation->book->title}}</h2>

<div>
    <img src="{{ $reservation->display_image_path }}" alt="book image"
         style='max-width:250px;max-height:400px'>
    <div>
        <h2>{{$reservation->book->title}}</h2>
        <p>予約しています</p>
        <form action="{{ route('reservations.destroy', ['reservationId' => $reservation->id]) }}" method="POST">
            @method('DELETE')
            @csrf
            <input type="submit" value="予約を取り消す">
        </form>
    </div>
    <div>
        <p>以下の日程で予約しています</p>
        <h4>
            <span>{{ $reservation->display_start_at }}</span> -
            <span>{{ $reservation->display_end_at }}</span>
        </h4>
    </div>
</div>
