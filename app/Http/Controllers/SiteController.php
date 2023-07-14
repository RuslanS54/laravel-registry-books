<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;
class SiteController extends Controller
{
    public function index(Request $request)
    {
        $genre_filter = [];
        $query = Book::query();
        $genre_filter = $request['genre_filter'];
        if ($request->submit == 'search') {
            
            
            
            if ($request['genre_filter']){
                $query
                ->whereIn('book_genre.genre_id',$genre_filter)
                ->havingRaw('count(DISTINCT book_genre.genre_id) ='. count($genre_filter));
            }
            $query
            ->select('books.*')
            ->join('book_genre','book_genre.book_id', '=', 'books.id')
            ->where('books.name', 'like', '%' . request('title') . '%')
            ->where('users.name', 'like', '%' . request('author') . '%')
            ->where( 'books.type', '=', request('type') )
            ->join('users', 'books.user_id', '=', 'users.id')
            ->Join('genres', 'genres.id', '=', 'book_genre.genre_id' )
            ->groupBy('books.id');
   
        }
        $books = $query->orderBy('books.name')->get();
       
        return view('index', 
        [
            'books' => $books,
            'genres' => Genre::all(),
            'types' => Book::select('type')->distinct()->get()->toArray(),
            'genre_filter' => $genre_filter
        ]
    );
    }
}
