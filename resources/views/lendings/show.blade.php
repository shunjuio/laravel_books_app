<h3>Title:{{$lending->book->title}}</h3>
<img src="{{ asset($lending->book->image_path)}}" style='max-width:500px;max-height:500px'>
<br>

<form action="" method="PUT">
    @csrf
    <input type="submit" value="返却する" >
</form>

    <p>{{\Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日')}}　まで借りています</p>