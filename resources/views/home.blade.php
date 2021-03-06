@extends('layouts.app')

@section('content')



    <get-data
            :prop_current_route="{{json_encode(\Request::route()->getName())}}"
            :prop_current_user="{{
                ($currentUser) ? json_encode($currentUser): '{}'
            }}"
            :prop_user="{{json_encode($user)}}"
    ></get-data>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="row">
                    <img class="profile_pic"
                         src="{{$user->avatarUrl}}">
                </div>


                <div class="row pt-2">
                    <div class="col pl-0">
                        <h3>
                            {{$user->name}}
                        </h3>
                    </div>
                    <div class="col-fluid">
                        @if(Auth::check())
                            @if((Auth::user()->slug !== $user->slug))
                                <follow-button></follow-button>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <a href="{{route('user.profile', $user->slug)}}" style="color: gray;">{{'@'.$user->slug }}</a>
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

                @if($user->id == Auth::id() AND Route::currentRouteName() == 'timeline')
                    <timeline
                            :user="{{$user}}"
                            :current_route_name="'timeline'"
                    ></timeline>
                @else
                    <timeline
                            :user="{{$user}}"
                    ></timeline>
                @endif
            </div>
            <div class="col-md-3 well well-lg">
                <featured-users
                        :user="{{$user}}"
                ></featured-users>
            </div>
        </div>
    </div>
@endsection
