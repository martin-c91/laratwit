@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="col-sm-3">
                    <img class="profile_pic"
                         src="https://pbs.twimg.com/profile_images/378800000841793222/63b002503ab73a6abffaeaf213279f52_400x400.jpeg">
                </div>
                <br>

                <h3>
                    {{$user->name}}
                </h3>
                <a href="{{route('user.profile', $user->slug)}}" style="color: gray;">{{'@'.$user->slug }}</a>
                <p>
                    Presenter for Channel 4 News, blogger for the Telegraph. 2 husbands: Jon on-screen, John off-screen. Full-time job: mum of 2. Facebook http://on.fb.me/1yJVG7w
                </p>

            </div>
            <div class="col-md-6">
                @if (session('status'))
                    <div class="">

                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif
                <div class="card border-0 new-tweet-form">
                    @include('partials/new-tweet-form')
                </div>

                <br>
                <div class="panel">
                    <div class="panel-header">Timeline</div>
                    
                    @foreach ($tweets as $tweet)
                        @include('partials.tweet-card')
                    @endforeach

                </div>
            </div>
            <div class="col-md-3 well well-lg">

                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        Featured Users
                    </div>

                    <ul class="list-group list-group-flush border-0">
                        <li class="list-group-item border-0">Cras justo odio</li>
                        <li class="list-group-item border-0">Dapibus ac facilisis in</li>
                        <li class="list-group-item border-0">Vestibulum at eros</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
