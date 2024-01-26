@extends('layouts.comparison')

@section('content')


<div class="container">
   <p>楽天で検索をする</p>
    <div class="search">
        <form action="{{ route('search', ['page' => 1]) }}"method="GET">
            <input type="text" name="keyword" placeholder="検索キーワードを入力" >
            <input type="hidden" name="sort" value="{{ request('sort', 'standard') }}">
            {{-- <input type="text" name="genreId" placeholder="ジャンルIDを入力" value="{{ request('genreId') }}"> --}}
            <button type="submit">検索</button>
        </form>
    </div>
</div>
@endsection
