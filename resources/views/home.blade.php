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
                    Cathy Newman
                </h3>
                <a style="color: gray;">@CathyNewman</a>
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
                <div class="card">
                    <div class="card-header">Timeline</div>


                    @foreach ($tweets as $tweet)
                        @include('partials.tweet-card')
                    @endforeach

                    <div class="card-body">
                        <div style="float: left; width: 48px;">
                            <img class="avatar"
                                 src="https://pbs.twimg.com/profile_images/378800000841793222/63b002503ab73a6abffaeaf213279f52_400x400.jpeg"
                                 alt="avatar">
                        </div>
                        <div style="margin-left: -48px; margin-left: 58px; ">
                            <h6>@CathyNewman</h6>
                            Congratulations to all our wonderful nominees 👏👏👏 take a look at the full list 👉 http://www.bafta.org/television/awards/tv-2018 …
                            We'll announce the winners on Sunday 13 May 😍🏆 #BAFTATV
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-3 well well-lg"></div>
        </div>
    </div>
@endsection
