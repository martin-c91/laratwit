<div class="panel-body mt-3 mb-3">
    <div style="float: left; width: 48px;">
        <img class="avatar"
             src="{{$tweet->user->avatar}}"
             alt="avatar">
    </div>
    <div style="margin-left: -48px; margin-left: 58px; ">
        <h6><a href="{{url('/'.$tweet->user->slug)}}">{{'@'.$tweet->user->slug }}</a></h6>
        {{$tweet->content}}
    </div>

    <div class="float-right">
        created: {{$tweet->created_at->diffForHumans()}}
    </div>

</div>