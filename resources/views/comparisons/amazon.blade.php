@extends('layouts.comparison')

@section('content')
{{-- <p>{{$userID}}</p> --}}
{{-- @dd($items) --}}
{{-- @dd($items[0]['Images']['Primary']['Medium'] ) --}}
{{-- {{$items[0]['ItemInfo']['Title']['DisplayValue']}} --}}
<div class="container">
   <div class="search">
      <form action="/amazon-search" method="post">
         @csrf
          <input type="text" name="name" placeholder="検索キーワードを入力" value="{{ request('name')}}">
          <button type="submit">検索</button>
      </form>
  </div>

    @if(request('name'))
  <p>検索キーワード: {{ request('name') }}</p>
   @endif

   <div class="contents_all row">
@foreach ($items as $item) 
<div class="content col-sm-3" >
<img class="img" src="{{ $item['Images']['Primary']['Medium']['URL'] }}" alt="{{ $item['ItemInfo']['Title']['DisplayValue'] }}">
   <p> {{$item['ItemInfo']['Title']['DisplayValue']}}
      <p class="price">{{ $item['Offers']['Listings']['0']['Price']['Amount'] }}円</p>
         <!-- 他の情報も表示可能 -->
         <form action="/amazon_save" method="post">
            @csrf
            <input type="hidden" name="userid" value="{{$userID}}">
            <input type="hidden" name="name" value="{{$item['ItemInfo']['Title']['DisplayValue']}}">
            <input type="hidden" name="price" value="{{$item['Offers']['Listings']['0']['Price']['Amount']}}">
            <input type="hidden" name="img" value="{{$item['Images']['Primary']['Medium']['URL'] }}">
            <input type="hidden" name="shop" value="Amazon">
            <input type="submit" value="情報を格納">
        </form>
      </div>
@endforeach

</div>



</div>
</div>
@endsection
