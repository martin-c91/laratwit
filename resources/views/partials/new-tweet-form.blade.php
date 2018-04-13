<form class="form-control" method="POST" action="{{ route('new-tweet') }}">
    @csrf
    <div class="form-group">
        <label for="Content">Tweets</label>
        <textarea class="form-control" name="content" rows="3"></textarea>
    </div>
    <div class="form-group float-right">
        <button class="btn btn-default" action="" name="Submit">Submit</button>
    </div>
</form>