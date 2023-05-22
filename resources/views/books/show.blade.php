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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reservations.store') }}" method="POST">
  @csrf
  <input name="book_id" type="hidden" value="{{$book->id}}">
  <input name="start_at" type="date" min="{{$book->default_date}}" value="{{$book->default_date}}"> から
  <br>
  <input name="end_at" type="date" min="{{$book->default_date}}" value="{{$book->default_date}}"> まで
  <br>
  <input type="submit" value="予約する">
</form>
