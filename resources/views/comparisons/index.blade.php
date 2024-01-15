@extends('layouts.app')

@section('content')
<header>

</header>



<div class="table-wrap">
    <table>
        <th>ID</th>
        <th>商品名</th>
        <th>値段</th>
        <th>画像</th>
        <th>ショップ名</th>
        <th>保存日</th>
        <th>ボタン</th>
        @foreach ($comparisons as $comparison)  
            <tr>
                <td>{{ $comparison->id }}</td>
                <td>{{ $comparison->name }}</td>
                <td>{{ $comparison->price }}円</td>
                <td><img src="{{ $comparison->img }}"></td>
                <td>{{ $comparison->shop }}</td>
                <td>{{ $comparison->created_at }}</td>
                <td>
                    <form action="{{ url('index/' . $comparison->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                    <input type="submit" value="削除" class="btn btn-danger">
                    </form>
                </td>
            </tr>
        @endforeach


        
    </table>