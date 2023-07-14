@extends('layouts.main')

@section('content')
    <div class="container my-5 flex-fill">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <form action="/book/{{ $book->id }}/admin" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h3>{{ $book->name }}'s Описание</h3>
                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Название</label>
                                <div class="col-sm-6">
                                    <input value="{{ $book->name }}" type="text" class="form-control" name="name">

                                    <span>{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Автор</label>
                                <div class="col-sm-6">
                                    <select class="form" name="author">
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"
                                                {{ $author->id === $book->user->id ? 'selected' : '' }}> {{ $author->name }}
                                            </option>
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





                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Жанры</label>
                                <div class="col-sm-4">
                                    @foreach ($genres as $genre)
                                        <div class="form-group form-check" onclick="checkGenres({{ $genre->id }})">
                                            <input class="form-check-input" type="checkbox" name="genres_new[]"
                                                value="{{ $genre->id }}" id="{{ $genre->id }}"
                                                @foreach ($book->genres as $bookGenre)
                        {{ $genre->name === $bookGenre->name ? 'checked' : '' }} @endforeach>
                                            <label class="form-check-label">
                                                {{ $genre->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <span>{{ $errors->first('genres') }}</span>
                                </div>
                            </div>

                            {{-- Genre Input --}}
                            <input value="" type="text" id="genres" class="form-control" name="genres" hidden>
                            <div class="row mb-3">




                            </div>
                            {{-- Hidden Input --}}
                            <button type="submit" class="btn btn-info text-white col-sm-4">Обновление</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
