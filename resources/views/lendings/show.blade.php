<h3>Title:{{$lending->book->title}}</h3>
<img src="{{ asset($lending->book->image_path)}}" style='max-width:500px;max-height:500px'>
<br>

<form action="{{route('lendings.update', ['lendingId' =>$lending->id])}}" method="POST">
    @csrf
    @method('PUT')
    <input type="submit" value="返却する">
</form>

@if($lending->end_at < $today)
    <p>返却期限過ぎています！！</p>
@else
    <p>{{\Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日')}} まで借りています</p>
@endif
