<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;
    protected $fillable = [
        'tvmaze_id',
        'imdb_id',
        'name',
        'rating',
        'image_url',
        'nextepisode_season',
        'nextepisode_episode',
        'nextepisode_url',
        'nextepisode_airstamp',
        'popular'
    ];
    protected $nullable = [
        'imdb_id',
        'image_url',
        'rating',
        'nextepisode_season',
        'nextepisode_episode',
        'nextepisode_url',
        'nextepisode_airstamp'
    ];
    
}
