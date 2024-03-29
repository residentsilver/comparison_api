    @extends('layouts.comparison')
    @php
        $url = route('search', ['page' => 1]);
    @endphp
    @section('content')

    {{-- @dd(request('sort')); --}}
    {{-- @dd($sort); --}}


<div class="container">
    <div class="search">
        <form action="{{ route('search', ['page' => 1]) }}" method="GET">
            <input type="text" name="keyword" value="{{ request('keyword')}}">
            <input type="hidden" name="sort" value="{{ request('sort', 'standard') }}">
            {{-- <input type="text" name="genreId" placeholder="ジャンルIDを入力" value="{{ request('genreId') }}"> --}}
            <button type="submit">検索</button>
        </form>
    </div>

    <div class="search">
        <!-- フォーム -->
        <form id="sort-form" action="{{ route('search', ['page' => $currentPage]) }}" method="get">
    <!-- ドロップダウン -->
            並べ替え　　
            <select id="dropdown-select" name="sort">
                <option value="example">順番を選択</option>
                <option value="+itemPrice">価格昇順</option>
                <option value="-itemPrice">価格降順</option>
                <option value="+updateTimestamp">最新順</option>
                <option value="-updateTimestamp">古い順</option>
                <option value="standard">標準</option>
            </select>
            <input type="hidden" name="keyword" value="{{ request('keyword')}}">
            <input type="hidden" name="page" value="{{ request('currentPage')}}">
            {{-- <button type="submit">検索</button> --}}
        </form>
    </div>


    @if(request('keyword'))
        <p>検索キーワード: {{ request('keyword') }}</p>
    @endif

        <div class="contents_all row">
        @if(isset($items))
            <!-- 検索結果表示などを追加 -->
            @foreach($items as $item)
                <div class="content col-sm-3" >
                    @if(isset($item['img']))
                    <img class="img" src="{{ $item['img'] }}" alt="{{ $item['title'] }}">
                @else
                    <p>画像なし</p>
                @endif
                    <p >{{ $item['title'] }}</p>
                    <p class="price">{{ $item['price'] }}円</p>

                <p>{{ $item['shop'] }}</p>
                    <!-- 他の情報も表示可能 -->

                <form action="/product_save" method="post">
                    @csrf
                    <input type="hidden" name="userid" value="{{$userID}}">
                    <input type="hidden" name="name" value="{{$item['title']}}">
                    <input type="hidden" name="price" value="{{$item['price']}}">
                    <input type="hidden" name="img" value="{{$item['img']}}">
                    <input type="hidden" name="shop" value="{{$item['shop']}}">
                    <input type="submit" value="情報を格納">
                </form>
            </div>
            @endforeach
        @endif

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item{{ $currentPage == 1 ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $currentPage > 1 ? route('search', ['page' => $currentPage - 1, 'keyword' => request('keyword'),'sort' =>request('sort')])  : '#' }}" tabindex="-1">Previous</a>
                </li>
                @for ($i = max(1, $currentPage - 1); $i <= min($totalPages, $currentPage + 1); $i++)
                    <li class="page-item{{ $i == $currentPage ? ' active' : '' }}">
                        <a class="page-link" href="{{ route('search', ['page' => $i, 'keyword' => request('keyword'),'sort' =>request('sort')]) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item{{ $currentPage == $totalPages ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $currentPage < $totalPages ? route('search', ['page' => $currentPage + 1, 'keyword' => request('keyword'),'sort' =>request('sort')])  : '#' }}">Next</a>
                </li>
            </ul>
        </nav>
        
        
    </div>
</div>

<script>
    //ページのDOM要素がすべて読み込まれたら、発火する
    //第二引数は無名関数
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('dropdown-select').addEventListener('change', function () {
    //ドロップダウンが変更されたときにフォームをサブミット
            document.getElementById('sort-form').submit();
        });
    });
</script>
    @endsection
