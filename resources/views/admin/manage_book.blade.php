@extends('layouts.main')

@section('content')
    <div class="container my-5 flex-fill">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <form action="/admin/book" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h3>Информация о книге</h3>
                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Название</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name">
                                    <span>{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Автор</label>
                                <div class="col-sm-6">
                                    <select class="form" name="author">
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"> {{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                    <span>{{ $errors->first('author') }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Тип</label>
                                <div class="col-sm-4">

                                    <div class="form-group form">
                                        <select class="form" name="type">
                                            @foreach ($types as $type)
                                                <option> {{ $type['type'] }}</option>
                                            @endforeach
                                        </select>


                                    </div>




                                    <span>{{ $errors->first('type') }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Жанр</label>
                                <div class="col-sm-4">
                                    @foreach ($genres as $genre)
                                        <div class="form-group form-check">
                                            <input class="form-check-input" type="checkbox" name="genres[]"
                                                value="{{ $genre->id }}" id="check{{ $genre->id }}">

                                            <label class="form-check-label">
                                                {{ $genre->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <span>{{ $errors->first('genres') }}</span>
                                </div>
                            </div>




                            <button type="submit" class="btn btn-info text-white col-sm-4">Добавить</button>
                        </div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Автор</th>
                            <th scope="col">Жанр</th>
                            <th scope="col">Тип издание</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->user->name ?? '' }}</td>
                                <td>
                                    @foreach ($book->genres as $genre)
                                        {{ $genre->name }}
                                    @endforeach
                                </td>
                                <td>{{ $book->type }}</td>
                                <td>{{ date('d/m/Y', strtotime($book->created_at)) }}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-block">
                                        <a href="/book/{{ $book->id }}/admin" class="btn">Редактировать</a>
                                        <form action="/book/{{ $book->id }}/admin" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn" type="submit">Удалить</button>
                                        </form>
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
