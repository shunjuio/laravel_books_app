<h3>【※お知らせ】 貸出期限間近の本があります</h3>
@foreach($lendings as $lending)
    <div>
        <p>タイトル：
            <a href="{{ route('books.show', ['bookId'=> $lending->book->id])}}">{{ $lending->book->title }}</a>
        </p>
        <img src="{{ $message->embed($lending->book->image) }}" style="max-width:300px;max-height:300px">
        <p>貸出期限：{{Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日')}} まで</p>
    </div>
@endforeach
