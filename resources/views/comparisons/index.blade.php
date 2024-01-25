@extends('layouts.comparison')

@section('content')
<header>

</header>



<div class="table-wrap">

    {{$name}}さんの保存した商品一覧
<form action="/index-search" method="GET">	<table>
<label for="search">商品名で検索：</label>	
<input type="text" name="search" id="search" value="{{ request('search') }}">	
<input type="submit" value="検索">
</form>

<div class="table-borderless">
    <table class="table table-hover">
        <thead class="thead-dark">
        <th>ID</th>
        <th>商品名</th>
        <th>値段</th>
        <th>画像</th>
        <th>ショップ名</th>
        <th>保存日</th>
        <th>ボタン</th>
    </thead>
    <tbody>

        @foreach ($comparisons as $comparison)  
            <tr>
                <td>{{ $comparison->favorite_id }}</td>
                <td>{{ $comparison->name }}</td>
                <td>{{ $comparison->price }}円</td>
                <td><img src="{{ $comparison->img }}"></td>
                <td>{{ $comparison->shop }}</td>
                <td>{{\Carbon\Carbon::parse($comparison->created_at)->format('Y-m-d')}}</td>
                <td>
                    <form action="{{ url('index/' . $comparison->favorite_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    <input type="submit" value="削除" class="btn btn-danger">
                    </form>
                </td>
            </tr>
    </tbody>
        @endforeach


        </table>
    </div>
</div>