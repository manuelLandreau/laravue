<form class="ui form" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <div class="field">
        <label>Email</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    </div>

    @if ($errors->has('email'))
        <div class="ui red message">{{ $errors->first('email') }}</div>
    @endif

    <button type="submit" class="ui button">
        Envoyer le mail de réinitialisation
    </button>
</form>
