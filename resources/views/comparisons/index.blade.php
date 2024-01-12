@extends('layouts.app')

@section('content')

<div class="table-wrap">
    <table>
        <th>お名前</th>
        <th>ご住所</th>
        <th>電話番号</th>
        @foreach ($comparisons as $comparison)
            <tr>
                <td>{{ $comparison->id }}</td>
                <td>{{ $comparison->name }}</td>
                <td>{{ $comparison->price }}</td>
                <td><img src="{{ $comparison->img }}"></td>
                <td>{{ $comparison->shop }}</td>

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