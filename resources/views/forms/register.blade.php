<form class="ui form" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="field">
        <label>Nom</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    @if ($errors->has('name'))
        <div class="ui red message">{{ $errors->first('name') }}</div>
    @endif

    <div class="field">
        <label>Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
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


    <button type="submit" class="ui button">
        S'inscrire
    </button>
</form>