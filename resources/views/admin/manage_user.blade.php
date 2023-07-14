@extends('layouts.main')

@section('content')
    <div class="container my-5 flex-fill">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/user1" method="POST">
                            @csrf
                            <h3> Добавить нового пользователя </h3>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Имя</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <span>{{ $errors->first('name') }}</span>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <span>{{ $errors->first('email') }}</span>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Пароль</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <span>{{ $errors->first('password') }}</span>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Профиль</label>
                                <div class="col-sm-6">
                                    <select class="form-select" name="role_id">
                                        <option value="1">Администратор</option>
                                        <option value="2">Автор</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info text-white col-sm-4">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container my-5 flex-fill">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Имя</th>
                            <th scope="col">Email</th>
                            <th scope="col">Профиль</th>
                            <th scope="col">Количество книг</th>
                            <th scope="col">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ count($user->books) }}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        <a href="/user/{{ $user->id }}/admin" class="btn">Детали</a>
                                        @if ($user->role->id === 2)
                                            <form action="/user/{{ $user->id }}/admin" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn" type="submit">Удалить</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
