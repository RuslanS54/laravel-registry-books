@extends('layouts.main')
@section('content')
    <form method="post" action="/login" class="w-50 form-control mx-auto">
        <h2>Вход в панель администрирования</h2>
        @csrf
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты" required maxlength="255"
                value="{{ old('email') ?? '' }}">
            <span>{{ $errors->first('email') }}</span>
        </div>
        <br>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Ваш пароль" required maxlength="255"
                value="">
            <span>{{ $errors->first('password') }}</span>
        </div>
        <br>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-info text-white ">Войти</button>
        </div>
    </form>
@endsection
