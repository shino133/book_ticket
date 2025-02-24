<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ManagerShowController extends Controller
{
    public function index(): View
    {
        return view('manager.show-index', [
            'shows' => Show::with('movie')->get(),
        ]);
    }

    public function create(): View
    {
        return view('manager.show-create', [
            'movies' => Movie::pluck('title', 'id'),
            'rooms' => Room::pluck('size', 'id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            'room_id' => ['required', Rule::exists(Room::class, 'id')],
            'date' => ['required', 'date', 'after:today'],
            'price' => ['required', 'numeric', 'gte:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'after:start_time'],
        ]);

        $validated['remaining_seats'] = Room::findOrFail($validated['room_id'])->size;

        $show = Show::create($validated);

        return redirect()->route('manager.shows.edit', $show)->with([
            'flash' => 'success',
            'message' => 'Added show successfully',
        ]);
    }

    public function show(Show $show): View
    {
        return view('manager.show-show', compact('show'));
    }

    public function edit(Show $show): View
    {
        return view('manager.show-edit', [
            'show' => $show,
            'movies' => Movie::pluck('title', 'id'),
            'rooms' => Room::pluck('size', 'id'),
        ]);
    }

    public function update(Request $request, Show $show): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            'date' => ['required', 'date', 'after:today'],
            'price' => ['required', 'numeric', 'gte:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'after:start_time'],
        ]);

        $show->update($validated);

        return redirect()->route('manager.shows.edit', $show)->with([
            'flash' => 'success',
            'message' => 'Updated Show Successfully',
        ]);
    }

    public function destroy(Show $show): RedirectResponse
    {
        $show->delete();

        return redirect()->route('manager.shows.index')->with([
            'flash' => 'success',
            'message' => 'Successfully deleted show.',
        ]);
    }
}
