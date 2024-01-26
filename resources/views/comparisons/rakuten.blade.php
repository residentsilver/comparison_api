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

    </div>


    @if(request('keyword'))
        <p>検索キーワード: {{ request('keyword') }}</p>
    @endif

    {{-- <div class="container-sort">
        <form action="/rakuten-search/1" method="GET">
        <input type="hidden" name="keyword" placeholder="検索キーワードを入力" value="{{ request('keyword') }}">
        <select name="sort_key">
            <option value="name" {{ request('sort_key') === 'name' ? 'selected' : '' }}>タイトル名</option>
            <option value="price" {{ request('sort_key') === 'price' ? 'selected' : '' }}>価格</option>
            <!-- 他のソート対象の項目を追加 -->
        </select>
        <select name="sort_order">
            <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>昇順</option>
            <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>降順</option>
        </select>
        <input type="submit" value="ソート">
    </form>
    </div> --}}



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
                    {{-- <input type="hidden" name="img" value="{{$item['img']}}"> --}}
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
    @endsection
