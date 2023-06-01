<style>
    .book {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        justify-content: flex-start;
    }

    .li {
        padding: 20px;
    }
</style>
<h3>タグ検索結果: {{$tag->name}} 本一覧</h3>
<div class="book">
    @foreach($books as $book)
        <li class="li">
            <img src="{{ '/storage/'. $book->image_path}}" style='max-width:300px;max-height:500px'>
            <br>
            Title: <a href="{{ route('books.show', ['bookId'=> $book->id])}}">{{ $book->title }} </a>
            <table>
                <tr>
                    <td>タグ:</td>
                    @foreach($book->tags as $tag)
                        <td><a href="{{route('books.tags.index', ['tagId'=> $tag->id])}}">{{$tag->name}}</a></td>
                    @endforeach
                </tr>

            </table>

            <p>{{ $status[$book->id]}}</p>
        </li>
    @endforeach
</div>
