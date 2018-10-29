<form class="ui form" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="field">
        <label>Email</label>
        <input id="email" type="email" name="email" value="{{ $email or old('email') }}" required autofocus>
    </div>

    @if ($errors->has('email'))
        <div class="ui red message">{{ $errors->first('email') }}</div>
    @endif

    <div class="field">
        <label>Mot de passe</label>
        <input id="password" type="password" name="password" required>
    </div>

    @if ($errors->has('password'))
        <div class="ui red message">{{ $errors->first('password') }}</div>
    @endif

    <div class="field">
        <label>Confirmation</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>
    </div>

    @if ($errors->has('password_confirmation'))
        <div class="ui red message">{{ $errors->first('password_confirmation') }}</div>
    @endif

    <button type="submit" class="btn btn-primary">
        Réinitialiser le mot de passe
    </button>
</form>