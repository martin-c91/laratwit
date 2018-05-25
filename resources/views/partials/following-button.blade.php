    @if($is_following)
        <form action="/{{$user->slug}}/unfollow" method="POST">
            @method('POST')
            @csrf
            <button type="submit" class="btn btn-secondary">UnFollow</button>
        </form>
    @else
        <form action="/{{$user->slug}}/follow" method="POST">
            @method('POST')
            @csrf
            <button type="submit" class="btn btn-primary">Follow</button>
        </form>
    @endif
