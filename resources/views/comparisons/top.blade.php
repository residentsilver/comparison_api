    @extends('layouts.comparison')

    @section('content')

    {{-- @dd($items); --}}


<div class="container">
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="keyword" placeholder="検索キーワードを入力" value="{{ request('keyword')}}">
            {{-- <input type="text" name="genreId" placeholder="ジャンルIDを入力" value="{{ request('genreId') }}"> --}}
            <button type="submit">検索</button>
        </form>
        
    </div>

@if(request('keyword'))
    <p>検索キーワード: {{ request('keyword') }}</p>
@endif

<div class="container">
    <form action="{{ route('search') }}" method="GET">
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
</div>



        <div class="contents_all">
        @if(isset($items))
            <!-- 検索結果表示などを追加 -->
            @foreach($items as $item)
                <div class="content" >
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
                    <input type="hidden" name="name" value="{{$item['title']}}">
                    <input type="hidden" name="price" value="{{$item['price']}}">
                    <input type="hidden" name="img" value="{{$item['img']}}">
                    <input type="hidden" name="shop" value="{{$item['shop']}}">
                    <input type="submit" value="情報を格納">
                </form>
            </div>
            @endforeach
        @endif

    </div>

    @endsection
