<h2><a href="/reservations" style="text-decoration: none;">予約している本の一覧</a> > {{$reservation->book->title}}</h2>

<div>
    <img src="{{ asset('storage/'. $reservation->book->image_path) }}" alt="book image" style='max-width:250px;max-height:400px'>
    <div>
        <h2>{{$reservation->book->title}}</h2>
        <p>予約しています</p>
        <form action="#" method="">
            <input type="submit" value="予約を取り消す">
        </form>
    </div>
    <div>
        <p>以下の日程で予約しています</p>
        <h4>
            <span>{{\Carbon\Carbon::parse($reservation->start_at)->format('Y-m-d')}}</span> -
            <span>{{\Carbon\Carbon::parse($reservation->end_at)->format('Y-m-d')}}</span>
        </h4>
    </div>
</div>
