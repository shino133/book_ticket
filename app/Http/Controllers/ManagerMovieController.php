<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Role;
use App\Models\Show;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagerMovieController extends Controller
{
    public function dashboard()
    {
        $shows = Show::with('movie')->get();
        $movies = Movie::with('category')->get();

        // Thống kê số lượng phim theo danh mục
        $categories = $movies->groupBy('category_id');
        $categoryLabels = $categories->map(fn($category) => $category[0]->category->title)->values();
        $categoryCounts = $categories->map(fn($category) => $category->count())->values();

        // Thống kê số lượng phim theo năm phát hành
        $releaseYears = $movies->map(function ($movie) {
            $movie->release_year = $movie->release_date->year;
            return $movie;
        })->sortBy('release_year')->groupBy('release_year');

        $years = $releaseYears->keys();
        $yearCounts = $releaseYears->map(fn($year) => $year->count())->values();

        return view('manager.dashboard', [
            'numOfShows' => $shows->count(),
            'numOfMovies' => $movies->count(),
            'numOfCustomers' => User::where('role_id', Role::CUSTOMER_CODE)->count(),
            'showsNextWeek' => $shows->whereBetween('date', [now(), now()->addWeek()])->count(),
            'categoryLabels' => $categoryLabels,
            'categoryCounts' => $categoryCounts,
            'years' => $years,
            'yearCounts' => $yearCounts,
        ]);
    }


    public function index()
    {
        return view('manager.movie-index', [
            'movies' => Movie::with('category')->get(),
        ]);
    }

    public function create()
    {
        return view('manager.movie-create', [
            'categories' => Category::pluck('title', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'title' => 'required|string|min:1|max:255',
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'language' => 'required|string|min:1|max:255|alpha',
            'rating' => 'required|numeric|between:0,5',
            'release_date' => 'required|date',
            'director' => 'required|string|min:1|max:255',
            'maturity_rating' => 'required|string|min:1|max:255|alpha_dash',
            'running_time' => 'required|date_format:H:i',
            'storyline' => 'required|string|min:1',
            'image' => 'required|image',
        ]);

        $attr['image'] = $request->file('image')->store('posters');

        $movie = Movie::create($attr);

        return redirect()->route('manager.movies.edit', $movie)->withSuccess('Added movie successfully');
    }

    public function show(Movie $movie)
    {
        return view('manager.movie-show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('manager.movie-edit', [
            'movie' => $movie,
            'categories' => Category::pluck('title', 'id'),
        ]);
    }

    public function update(Request $request, Movie $movie)
    {
        $attr = $request->validate([
            'title' => 'required|string|min:1|max:255',
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'language' => 'required|string|min:1|max:255|alpha',
            'rating' => 'required|numeric|between:0,5',
            'release_date' => 'required|date',
            'director' => 'required|string|min:1|max:255',
            'maturity_rating' => 'required|string|min:1|max:255|alpha_dash',
            'running_time' => 'required|date_format:H:i',
            'storyline' => 'required|string|min:1',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $attr['image'] = $request->file('image')->store('posters');
        }

        $movie->update($attr);

        return redirect()->route('manager.movies.edit', $movie)->withSuccess('Updated movie successfully');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('manager.movies.index')->withSuccess('Successfully deleted movie.');
    }
}
