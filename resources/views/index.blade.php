@extends('layouts.main')

@section('content')
    <div class="container mt-2">

        <form action="{{ route('index') }}" method="GET">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Название книги:</strong>
                        <input type="text" name="title" class="form-control" placeholder="Название книги"
                            value="{{ request('title') }}">
                        <strong>Автор:</strong>
                        <input type="author" name="author" class="form-control" placeholder="Автор"
                            value="{{ request('author') }}">
                        <strong>Жанры:</strong><br>
                        @foreach ($genres as $genre)
                            <input class="form-check-input" type="checkbox" name="genre_filter[]"
                                value="{{ $genre->id }}"
                                {{ in_array($genre->id, $genre_filter ?? []) ? 'checked' : '' }}>{{ $genre->name }}
                            </label><br>
                        @endforeach
                        <strong>Тип:</strong><br>
                        <select class="form" name="type">
                            @foreach ($types as $type)
                                <option> {{ $type['type'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" name="submit" value="search" class="btn btn-primary">Поиск</button>
            </div>
    </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Название книги</th>
                <th>Жанры</th>
                <th>Тип издания</th>
                <th>Автор</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->name }}</td>
                    <td>
                        @foreach ($book->genres as $genre)
                            {{ $genre->name ?? '' }}<br>
                        @endforeach
                    <td>{{ $book->type }}</td>
                    </td>
                    <td>{{ $book->user->name ?? '' }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
