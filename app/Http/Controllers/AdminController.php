<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Log;
class AdminController extends Controller
{
    public function manageBook()
    {
        return view('admin.manage_book', [
            'books' => Book::orderBy('updated_at','desc')->get(),
            'genres' => Genre::all(),
            'types' => Book::select('type')->distinct()->get()->toArray(),
            'authors' => User::where('role_id', 2)->get()
        ]);
    }
    public function insertBook(Request $req): RedirectResponse
    {

        $req->validate([
            'name' => ['required', 'unique:books', 'string', 'max:250'],
            'author' => ['required', 'string', 'max:250']
        ]);


        $respond = Book::query()->create([
            'name' => $req['name'],
            'user_id' => $req['author']

        ]);

        $genres =  request('genres');
        foreach ($genres as $genre){
            BookGenre::create([
                'book_id' => $respond->id,
                'genre_id' => $genre
            ]);
        }

        if ($respond){
            return back()->with('successMessage', 'Книга добавлена успешно');
        }
        return back()->with('errorMessage', 'Книга не добавлена');

    }
    public function bookDetail(Book $book)
    {
        return view('admin.book_detail', [
            'book' => $book,
            'genres' => Genre::all(),
            'types' => Book::select('type')->distinct()->get()->toArray(),
            'authors' => User::where('role_id', 2)->get(),
            'genres_new' => []
        ]);
    }
    public function updateBook(Book $book, Request $req): RedirectResponse
    {

        $req->validate([
            'name' => ['required', 'string', 'max:250'],
        ]);
    
        
        $genres =  $req['genres_new'];
        
        BookGenre::where('book_id', $book->id)->delete();
        if ($genres){
            foreach ($genres as $genre){
            BookGenre::create([
                'book_id' => $book->id,
                'genre_id' => $genre
            ]);
        }}
        

        $book->name = $req['name'];
        $book->user_id = $req['author'];
        $book->type = $req['type'];

        if ($book->save()) {
            return redirect('/admin/book')->with('successMessage', 'Обновление книги прошло успешно');
        }
        return back()->with('errorMessage', 'Обновление книги не удалось');
    }

    public function deleteBook(Book $book): RedirectResponse
    {
        $bookId = $book['id'];
        if ($book->delete()) {
            BookGenre::where('book_id', $bookId)->delete();
            return back()->with('successMessage', 'Книга успешно удалена');
        }
        return back()->with('errorMessage', 'Удаление книги не удалось');
    }

    // Manage Genre Page
    public function manageGenre()
    {

        return view('admin.manage_genre', [
            'genres' => Genre::all()
        ]);
    }

    // Genre Detail Page
    public function genreDetail(Genre $genre)
    {
        return view('admin.genre_detail', [
            'genre' => $genre,
            'books' => $genre->books
        ]);
    }

    // Handle Add Genre
    public function addGenre(Request $req): RedirectResponse
    {
        $validatedData = $req->validate([
            'name' => 'required|unique:genres'
        ]);

        if (Genre::create($validatedData)) {
            return back()->with('successMessage', 'Жанр добавлен успешно');
        }
        return back()->with('errorMessage', 'Добавление жанра не удалось');
    }

    // Handle Update Genre
    public function updateGenre(Genre $genre, Request $req): RedirectResponse
    {
        $validatedData = $req->validate([
            'name' => 'required|unique:genres'
        ]);

        $genre->name = $validatedData['name'];
        if ($genre->save()) {
            return back()->with('successMessage', 'Жанр успешно обновлен');
        }
        return back()->with('errorMessage', 'Обновление жанра не удалось');
    }

    // Handle Delete Genre
    public function deleteGenre(Genre $genre)
    {
        if ($genre->delete()) {
            return redirect('/admin/genre')->with('successMessage', 'Жанр успешно удален');
        }
        return back()->with('errorMessage', 'Удаление жанра не удалось');
    }

    // Manage User Page
    public function manageUser()
    {
        
        

        return view('admin.manage_user', [
            'users' =>  User::where('role_id', 2)->get()
        ]);
    }

    // User Detail Page
    public function userDetail(User $user)
    {
        return view('admin.user_detail', [
            'user' => $user
        ]);
    }

    // Handle Update User
    public function updateUser(User $user, Request $req): RedirectResponse
    {
        $validatedData = $req->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required'
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role_id = $validatedData['role_id'];
        if ($user->save()) {
            return back()->with('successMessage', 'Пользователь успешно обновлен');
        }
        return back()->with('errorMessage', 'Обновление пользователя не удалось');
    }

    // Handle Delete User
    public function deleteUser(User $user)
    {
        if ($user->delete()) {
            return redirect('/admin/user')->with('successMessage', 'Пользователь успешно удален');
        }
        return back()->with('errorMessage', 'Удаление пользователя не удалось');
    }
    
    public function addUser(Request $req): RedirectResponse
    {
        $validatedData = $req->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', ],
            'role_id' => ['required']
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        if (User::insert($validatedData)) {
            return back()->with('successMessage', 'Пользователь добавлен успешно');
        }
        return back()->with('errorMessage', 'Добавление пользователя не удалось');
    }
}
