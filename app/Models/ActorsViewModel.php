<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActorsViewModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'popularActors',
        'page'
    ];

    public $popularActors;
    public $page;

    public function __construct($popularActors, $page)
    {
        $this->popularActors = $popularActors;

        $this->page = $page;
    }

    public function popularActors()
    {
        return collect($this->popularActors)->map(function($actor) {
            return collect($actor)->merge([
                'profile_path' => $actor['profile_path']
                    ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$actor['profile_path']
                    : 'https://ui-avatars.com/api/?size=235&name='.$actor['name'],
                'known_for' => collect($actor['known_for'])->where('media_type', 'movie')->pluck('title')->union(
                    collect($actor['known_for'])->where('media_type', 'tv')->pluck('name')
                )->implode(', '),
            ])->only([
                'name', 'id', 'profile_path', 'known_for',
            ]);
        });
    }
}
