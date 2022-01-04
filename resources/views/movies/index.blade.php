@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4">
    <div class="popular-movies">
        <h2 class="mt-12 uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Movies</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach ($popularMovies as $movie)
              <x-movie-card :movie="$movie" :genres="$genres"  />
            @endforeach

        </div>
    </div> <!-- end pouplar-movies -->

    <div class="now-playing-movies pt-16">
        <h2 class="mt-8 uppercase tracking-wider text-orange-500 text-lg font-semibold">Now Playing</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach ($nowPlayingMovies as $movie)
                <x-movie-card :movie="$movie" :genres="$genres" />
            @endforeach
        </div>
    </div> <!-- end now-playing-movies -->

    <div class="now-playing-movies pt-16">
        <h2 class="mt-8 uppercase tracking-wider text-orange-500 text-lg font-semibold">Upcoming</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach ($upcommingMovies as $movie)
                <x-movie-card :movie="$movie" :genres="$genres" />
            @endforeach
        </div>
    </div> <!-- end now-playing-movies -->
</div>
@endsection