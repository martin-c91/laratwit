<div class="card-body">
    <div style="float: left; width: 48px;">
        <img class="avatar"
             src="{{$tweet->user->avatar}}"
             alt="avatar">
    </div>
    <div style="margin-left: -48px; margin-left: 58px; ">
        <h6><a href="{{url('/user/'.$tweet->user->slug)}}">{{'@'.$tweet->user->slug }}</a></h6>
        {{$tweet->content}}
    </div>

    <div class="float-right">
        created: {{$tweet->created_at->diffForHumans()}}
    </div>

</div>