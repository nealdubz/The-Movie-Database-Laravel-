<?php

namespace App\Http\Controllers;

use App\Models\ActorsViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ActorsController extends Controller
{
    public $page;
    public function index($page = 1)
    {
        $popularactors = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/popular?page=' . $page)
            ->json()['results'];
        $next = $page < 500 ? $page + 1 : null;
        $previous = $page > 1 ? $page - 1 : null;

        //dd($viewModel->popularActors);
        $popularActors = collect($popularactors)->map(function ($actor) {
            return collect($actor)->merge([
                'profile_path' => $actor['profile_path']
                    ? 'https://image.tmdb.org/t/p/w235_and_h235_face' . $actor['profile_path']
                    : 'https://ui-avatars.com/api/?size=235&name=' . $actor['name'],
                'known_for' => collect($actor['known_for'])->where('media_type', 'movie')->pluck('title')->union(
                    collect($actor['known_for'])->where('media_type', 'tv')->pluck('name')
                )->implode(', '),
            ])->only([
                'name', 'id', 'profile_path', 'known_for',
            ]);
        });
        return view('actors.index',  [
            'popularActors' => $popularActors,
            'next' => $next,
            'previous' => $previous,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/'.$id)
            ->json();

        $social = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/'.$id.'/external_ids')
            ->json();

        $credits = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/'.$id.'/combined_credits')
            ->json();

        $actor = collect($actor)->merge([
            'birthday' => Carbon::parse($actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($actor['birthday'])->age,
            'profile_path' => $actor['profile_path']
                ? 'https://image.tmdb.org/t/p/w300/'.$actor['profile_path']
                : 'https://via.placeholder.com/300x450',
        ])->only([
            'birthday', 'age', 'profile_path', 'name', 'id', 'homepage', 'place_of_birth', 'biography'
        ]);

        $social = collect($social)->merge([
            'twitter' => $social['twitter_id'] ? 'https://twitter.com/'.$social['twitter_id'] : null,
            'facebook' => $social['facebook_id'] ? 'https://facebook.com/'.$social['facebook_id'] : null,
            'instagram' => $social['instagram_id'] ? 'https://instagram.com/'.$social['instagram_id'] : null,
        ])->only([
            'facebook', 'instagram', 'twitter',
        ]);

        $castMovies = collect($credits)->get('cast');

        $knownForMovies = collect($castMovies)->sortByDesc('popularity')->take(5)->map(function($movie) {
            if (isset($movie['title'])) {
                $title = $movie['title'];
            } elseif (isset($movie['name'])) {
                $title = $movie['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($movie)->merge([
                'poster_path' => $movie['poster_path']
                    ? 'https://image.tmdb.org/t/p/w185'.$movie['poster_path']
                    : 'https://via.placeholder.com/185x278',
                'title' => $title,
                'linkToPage' => $movie['media_type'] === 'movie' ? route('movies.show', $movie['id']) : route('tv.show', $movie['id'])
            ])->only([
                'poster_path', 'title', 'id', 'media_type', 'linkToPage',
            ]);
        });

        return view('actors.show',
        [
            'actor' => $actor,
            'social' => $social,
            'credits' => $credits,
            'knownForMovies' => $knownForMovies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /** 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
