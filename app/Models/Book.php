<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;



class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'type',
    ];
    public static function bookFilter(Request $request)
    {
        $query = Book::query();
        if ($request->submit == 'search') {
            if ($request['genre_filter']){
                $query
                ->whereIn('book_genre.genre_id',$request['genre_filter'])
                ->havingRaw('count(DISTINCT book_genre.genre_id) ='. count($request['genre_filter']));
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
        
    return $query->orderBy('books.name')->get();
    }

    protected $casts = [
        'created_at' => 'datetime:d/m/Y', // Change your format
        'updated_at' => 'datetime:d/m/Y',
    ];
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
