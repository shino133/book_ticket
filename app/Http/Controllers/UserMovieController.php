<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserMovieController extends Controller
{
    public function index(Request $request): View
    {
        $movies = Movie::query()
            ->with('category')
            ->filter($request->all())
            ->paginate(6)
            ->withQueryString();

        return view('movie.index', compact('movies'));
    }

    public function show(Movie $movie): View
    {
        return view('movie.show', [
            'movie' => $movie,
            'shows' => $movie->shows()
                ->where('date', '>', now())
                ->where('remaining_seats', '>', 0)
                ->get(),
            'recommendations' => Movie::where('category_id', $movie->category_id)
                ->where('id', '!=', $movie->id)
                ->get(),
        ]);
    }
}
