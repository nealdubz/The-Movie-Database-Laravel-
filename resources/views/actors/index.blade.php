@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4">
        <div class="popular-movies">
            <h2 class="mt-12 uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Actors</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                {{-- {{dump($popularActors); }} --}}
                @foreach ($popularActors as $actor)
                    <div class="actor mt-8">
                        <a href="{{ route('actors.show', $actor['id']) }}">
                            <img src="https://image.tmdb.org/t/p/w235_and_h235_face{{ $actor['profile_path'] }}" alt="profile image"
                                class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="mt-2">
                            <a href="{{ route('actors.show', $actor['id']) }}"
                                class="text-lg hover:text-gray-300">{{ $actor['name'] }}</a>
                            <div class="text-sm truncate text-gray-400">{{ $actor['known_for'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> <!-- end pouplar-actors -->
        <div class="page-load-status my-8">
            <div class="flex justify-center">
                <div class="infinite-scroll-request spinner my-8 text-4xl">&nbsp;</div>
            </div>
            <p class="infinite-scroll-last">End of content</p>
            <p class="infinite-scroll-error">Error</p>
        </div>
        <div class="flex justify-between mt-16">
            @if (previous())
                <a href="/actors/page/{{ previous() }}">Previous</a>
            @else
                <div></div>
            @endif
            @if (next())
                <a href="/actors/page/{{ next() }}">Next</a>
            @else
                <div></div>
            @endif
        </div>
    </div>
@endsection
