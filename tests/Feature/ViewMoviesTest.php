<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Livewire\Livewire;

class ViewMoviesTest extends TestCase
{
    private function fakePopularMovies(){
        return Http::response([
            "results"=> [
                [
                    "adult" => false,
                    "backdrop_path" => "/eENEf62tMXbhyVvdcXlnQz2wcuT.jpg",
                    "genre_ids" => [
                      0 => 878,
                      1 => 28,
                      2 => 12
                    ],
                    "id" => 580489,
                    "original_language" => "en",
                    "original_title" => "Venom: Let There Be Carnage",
                    "overview" => "After finding a host body in investigative reporter Eddie Brock, the alien symbiote must face a new enemy, Carnage, the alter ego of serial killer Cletus Kasady ",
                    "popularity" => 9170.269,
                    "poster_path" => "/rjkmN1dniUHVYAtwuV3Tji7FsDO.jpg",
                    "release_date" => "2021-09-30",
                    "title" => "Venom: Let There Be Carnage",
                    "video" => false,
                    "vote_average" => 7.2,
                    "vote_count" => 4816,
                  ]
            ]
        ],200);
    }

    private function fakeNowPlayingMovies(){
        return Http::response([
            "results"=> [
                [
                    "adult" => false,
                    "backdrop_path" => "/eENEf62tMXbhyVvdcXlnQz2wcuT.jpg",
                    "genre_ids" => [
                      0 => 878,
                      1 => 28,
                      2 => 12
                    ],
                    "id" => 580489,
                    "original_language" => "en",
                    "original_title" => "Now playing",
                    "overview" => "After finding a host body in investigative reporter Eddie Brock, the alien symbiote must face a new enemy, Carnage, the alter ego of serial killer Cletus Kasady ",
                    "popularity" => 9170.269,
                    "poster_path" => "/rjkmN1dniUHVYAtwuV3Tji7FsDO.jpg",
                    "release_date" => "2021-09-30",
                    "title" => "Now Playing: Let There Be Carnage",
                    "video" => false,
                    "vote_average" => 7.2,
                    "vote_count" => 4816,
                  ]
            ]
        ],200);
    }

    private function fakeSearchMovies(){
        return Http::response([
            "results"=> [
                [
                    "adult" => false,
                    "backdrop_path" => "/eENEf62tMXbhyVvdcXlnQz2wcuT.jpg",
                    "genre_ids" => [
                      0 => 878,
                      1 => 28,
                      2 => 12
                    ],
                    "id" => 580489,
                    "original_language" => "en",
                    "original_title" => "Jumanji",
                    "overview" => "After finding a host body in investigative reporter Eddie Brock, the alien symbiote must face a new enemy, Carnage, the alter ego of serial killer Cletus Kasady ",
                    "popularity" => 9170.269,
                    "poster_path" => "/rjkmN1dniUHVYAtwuV3Tji7FsDO.jpg",
                    "release_date" => "2021-09-30",
                    "title" => "Jumanji: Let There Be Carnage",
                    "video" => false,
                    "vote_average" => 7.2,
                    "vote_count" => 4816,
                  ]
            ]
        ],200);
    }

    public function test_the_main_page_shows_correct_info()
    {
        Http::fake([
            "https://api.themoviedb.org/3/movie/popular" => $this->fakePopularMovies(),
            "https://api.themoviedb.org/3/movie/now_playing" => $this->fakeNowPlayingMovies(),
        ]);

        $response = $this->get(route('movies.index'));
        $response->assertStatus(200);
        $response->assertSee('Popular Movies');
        $response->assertSee('Venom');
        $response->assertSee('Now Playing: Let There Be Carnage');
    }

    public function test_the_search_dropdown_works_correctly(){
        Http::fake([
            "https://api.themoviedb.org/3/search/movie?query=jumanji" => $this->fakeSearchMovies()
        ]);
        Livewire::test('search-dropdown')
        ->assertDontSee('jumanji')
        ->set('search', 'jumanji')
        ->assertSee('Jumanji');
    }

}
