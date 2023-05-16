@if($user)
  <h3>{{$user->name}}</h3>
@else
 <h3>名無し</h3>
@endif
<h2>Reservations/index</h2>
<div>
  <ul style="list-style-type: none;">
  @foreach($books as $book)
      <li class="li" >
        <img src="{{ 'storage/'. $book->image_path}}" style='max-width:300px;max-height:500px'>
        <br>
        <a href="{{ route('reservations.show', ['reservationId'=> $book->id] )}}"><span>{{ $book->title }}</span>
      </li>
    @endforeach
  </ul>

</div>
