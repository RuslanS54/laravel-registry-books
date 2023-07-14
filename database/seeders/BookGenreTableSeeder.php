<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookGenre;
use App\Models\Book;
use App\Models\Genre;

class BookGenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        // BookGenre::factory()->count(200)->create();
        foreach(Book::all() as $book) {

            foreach(Genre::all() as $genre) {

                if (rand(1, 100) > 70) {
                        $book->genres()->attach($genre->id);
                }
            }
            $book->save();
        }
    }
}
