<!--JeCodeLeSoir-->
@extends('base')
@section('content')
    <main class="main">
            <div class="messages">
                @foreach ($messages as $info)
                    <div id="{{ $info->id }}" class="message">
                        <span class="author">{{ $info->name }}</span> à dit :
                        <div class="text">{{ $info->message }}</div>
                        <span class="date">{{ $info->created_at }}</span>
                    </div>
                @endforeach
            </div>

            <div class="message-input">
                <form id="send-message-tchat" action="{{ url('api/send') }}" method="POST">
                    @csrf
                    <input type="text" name="name" id="name" placeholder="pseudo" required autocomplete="off">
                    <div class="text-send">
                    <input type="text" name="message" id="message" placeholder="votre message" required autocomplete="off">
                    <input type="submit" value=">">
                    <div class="line"></div>
                </div>
                </form>
            </div>
    </main>
@endsection