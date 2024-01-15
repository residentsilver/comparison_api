    @extends('layouts.app')

    @section('content')

    {{-- {{@dd($items)}} --}}

    <div class="container">
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="keyword" placeholder="検索キーワードを入力">
            <button type="submit">検索</button>
        </form>
    </div>

        <div class="contents_all">
        @if(isset($items))
            <!-- 検索結果表示などを追加 -->
            @foreach($items as $item)
                <div class="content" >
                    <p >{{ $item['title'] }}</p>
                    <p>{{ $item['price'] }}円</p>
                    @if(isset($item['img']))
                    <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}">
                @else
                    <p>画像なし</p>
                @endif
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