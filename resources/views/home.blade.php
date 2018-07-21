@extends('layouts.app')

@section('content')
    <div id="title" style="text-align: center;">
        <h1>Learn Laravel 5</h1>
        <div style="padding: 5px; font-size: 16px;">Learn Laravel 5</div>
    </div>
    <hr>
    <div id="content">
        <ul>
            @foreach ($tests as $test)
            <li style="margin: 50px 0;">
                <div class="title">
                    <a href="{{ url('test/'.$test->id) }}">
                        <h4>{{ $test->title }}</h4>
                    </a>
                </div>
                <div class="body">
                    <p>{{ $test->body }}</p>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
@endsection