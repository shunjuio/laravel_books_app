<style>
    .book{
        display: flex;
        flex-wrap: wrap;
        list-style:none;
        justify-content: flex-start;
    }
    .li{
        padding : 20px ;
    }
</style>
<h3>借りている本一覧</h3>
<div class="book">
    @foreach($lendings as $lending)
        <li class="li" >
            <img src="{{ 'storage/'. $lending->book->image_path}}" style='max-width:300px;max-height:500px'>
            <br>
            <p><a href="{{ route('books.show', ['bookId'=> $lending->book->id])}}">{{ $lending->book->title }}</p></a>
                <p>{{\Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日')}}　まで</p>
        </li>

    @endforeach
</div>
