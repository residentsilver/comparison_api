@extends('layouts.comparison')

@section('content')

<div class="container">
   <p>楽天で検索をする</p>
    <div class="search">
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="keyword" placeholder="検索キーワードを入力" value="{{ request('keyword')}}">
            <input type="hidden" name="page" value="{{$page}}">
            {{-- <input type="text" name="genreId" placeholder="ジャンルIDを入力" value="{{ request('genreId') }}"> --}}
            <button type="submit">検索</button>
        </form>
    </div>
</div>
@endsection
