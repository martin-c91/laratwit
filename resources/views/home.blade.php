@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="row">
                    <img class="profile_pic"
                         src="{{str_replace('normal.jpg', '400x400.jpg', $user->avatar)}}">
                </div>



                <div class="row pt-2">
                    <div class="col pl-0">
                        <h3>
                            {{$user->name}}
                        </h3>
                    </div>
                    <div class="col-fluid">
                        @includeWhen((Auth::user()->slug !== $user->slug), 'partials.following-button')
                    </div>
                </div>
                <div class="row">
{{--                    <a href="{{route('user.profile', $user->slug)}}" style="color: gray;">{{'@'.$user->slug }}</a>--}}
                </div>

                <div class="row">
                    <p>
                        {{$user->description}}
                    </p>
                </div>

            </div>
            <div class="col-md-6">
                @if (session('status'))
                    <div class="">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif
                @if (session('message'))
                    <div class="">

                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                    </div>
                @endif

                @if($user->id == Auth::id())
                    <div class="card border-0 new-tweet-form">
                        {{--@include('partials/new-tweet-form')--}}
                        <post-tweet-component></post-tweet-component>
                    </div>
                @endif

                <br>
                <div class="panel">
                    <div class="panel-header">Timeline</div>

                    <get-tweets-component></get-tweets-component>
                    {{--@foreach ($tweets as $tweet)--}}
                        {{--@include('partials.tweet-card')--}}
                    {{--@endforeach--}}

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
