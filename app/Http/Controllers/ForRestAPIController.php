<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class ForRestAPIController extends Controller
{
    public function BooksAndAuthors() {
        return Book::query()
            ->select('books.name as name', 'users.name as author')
            ->orderBy('books.id', 'ASC')
            ->join('users', 'books.user_id', '=', 'users.id')
            ->paginate(10);
    }
    public function Book(Book $book) {
        return Book::query()
            ->selectRaw('books.name as name, users.name as author, GROUP_CONCAT(genres.name) as genres')
            ->join('users', 'books.user_id', '=', 'users.id')
            ->where('books.id', '=',  $book->id )
            ->join('book_genre','book_genre.book_id', '=', 'books.id')
            ->join('genres', 'genres.id', '=', 'book_genre.genre_id')
            ->groupBy('books.id', 'books.name')
            ->orderBy('books.id', 'ASC')
            ->paginate(10);
    }
    public function AuthorsAndNumberBooks() {
        return User::query()
            ->selectRaw( 'users.id, users.name, count(*) as number_books')
            ->join('books', 'users.id' , '=', 'books.user_id')
            ->groupBy('users.id', 'users.name')
            ->paginate(10);
    }
    public function Author(User $user) {
        return User::query()
            ->selectRaw( 'users.id, users.name, GROUP_CONCAT(books.name) as books')
            ->join('books', 'users.id' , '=', 'books.user_id')
            ->groupBy('users.id', 'users.name')
            ->where('users.id', '=',  $user->id )->paginate(10);
    }
    public function GenresAndBooks() {
        return Genre::query()
            ->selectRaw( 'genres.id, genres.name, GROUP_CONCAT(books.name) as books')
            ->join('book_genre','book_genre.genre_id', '=', 'genres.id')
            ->join('books', 'books.id', '=', 'book_genre.book_id')
            ->groupBy('genres.id', 'genres.name')
            ->paginate(10);
    }
    public function updateBook(Book $book, Request $req) {
        if(!($book->user_id == auth()->user()->id)){
            return response()->json([
                'status' => false,
                'message' => 'Вы не можете менять данные книги другого автора.',
            ], 401);
        }
        else{
            $req->validate([
                'name' => ['required', 'string', 'max:250'],
            ]);

            $book->name = $req['name'];
            $book->type = $req['type'];
            
            $genres =  explode(',', $req['genres_new']);

            BookGenre::where('book_id', $book->id)->delete();
            if ($genres){
                foreach ($genres as $genre){
                BookGenre::create([
                    'book_id' => $book->id,
                    'genre_id' => intval($genre)
                ]);
            }}
            if ($book->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Вы изменили данные книги',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Обновление книги не удалось',
            ], 200); 
            
        }
    }
    public function deleteBook(Book $book) {
        if(!($book->user_id == auth()->user()->id)){
            return response()->json([
                'status' => false,
                'message' => 'Вы не можете удалить книгу другого автора.',
            ], 401);
        }
        $bookId = $book['id'];
        if ($book->delete()) {
            BookGenre::where('book_id', $bookId)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Вы удалили книгу',
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Удаление книги не удалось',
        ], 200); 
        
    }
    public function updateAuthor(User $user, Request $req) {
        if(!($user->id == auth()->user()->id)){
            return response()->json([
                'status' => false,
                'message' => 'Вы не можете менять данные другого автора.',
            ], 401);
        }
        else{
            $validatedData = $req->validate([
                'name' => ['required'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => ['required', 'min:8', ],
            ]);
        
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            if ($user->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Вы изменили данные автора',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'Обновление автора не удалось',
            ], 200); 
            
        }
    }
}


