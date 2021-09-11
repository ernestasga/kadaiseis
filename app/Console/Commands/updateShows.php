<?php

namespace App\Console\Commands;

use App\Models\Show;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class updateShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:shows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing shows';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $shows = Show::all();
        foreach($shows as $show){
            $apiUrl = "https://api.tvmaze.com/shows/".$show->tvmaze_id."?embed=nextepisode";
            $raw = Http::get($apiUrl);
            $raw = json_decode($raw);

            $rating = isset($raw->rating->average) ? $raw->rating->average : null;
            $nextepisode_season = isset($raw->_embedded->nextepisode->season) ? $raw->_embedded->nextepisode->season : null;
            $nextepisode_episode = isset($raw->_embedded->nextepisode->number) ? $raw->_embedded->nextepisode->number : null;
            $nextepisode_url = isset($raw->_embedded->nextepisode->url) ? $raw->_embedded->nextepisode->url : null;
            $nextepisode_airstamp = isset($raw->_embedded->nextepisode->airstamp) ? $raw->_embedded->nextepisode->airstamp : null;
            
            $show->update([
                'rating' => $rating,
                'nextepisode_season' => $nextepisode_season,
                'nextepisode_episode' => $nextepisode_episode,
                'nextepisode_url' => $nextepisode_url,
                'nextepisode_airstamp' => $nextepisode_airstamp
            ]);
        }

    }
}
