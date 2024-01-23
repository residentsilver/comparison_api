@extends('layouts.comparison')

@section('content')

<div class="container">
   <div class="search">
      <form action="/amazon-search" method="post">
         @csrf
          <input type="text" name="name" placeholder="検索キーワードを入力" value="{{ request('name')}}">
          <button type="submit">検索</button>
      </form>
  </div>
</div>
@endsection
