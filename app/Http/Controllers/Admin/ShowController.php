<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['getPopular']);
    }
    public function index()
    {
        
    }
    public function getPopular()
    {
        return Cache::remember(
            'popular',
            60*60*2,
            function () {
                $shows = Show::where('popular', 1)->get();
                $result = array();
                foreach($shows as $show){
                    array_push($result, $show->tvmaze_id);
                }
                return response()->json($result);
            }
        );
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'imdbid' => 'nullable|string',
            'rating' => 'nullable|numeric',
            'imageurl' => 'nullable|string',
            'nextepisode' => 'nullable|array'
        ]);
        $nextepisode = isset($validated['nextepisode']) ? $validated['nextepisode'] : null;
        $res = Show::create([
            'tvmaze_id' => $validated['id'],
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'imdb_id' => $validated['imdbid'],
            'image_url' => $validated['imageurl'],
            
            'nextepisode_season' => $nextepisode != null ? $validated['nextepisode']['season'] : null ,
            'nextepisode_episode' => $nextepisode != null ? $validated['nextepisode']['episode'] : null,
            'nextepisode_url' => $nextepisode != null ? $validated['nextepisode']['url'] : null,
            'nextepisode_airstamp' => $nextepisode != null ? $validated['nextepisode']['airstamp'] : null
        ]);
        if($res){
            return response()->json([
                'success' => 'Show saved successflly.',
            ]);
        }
        return response()->json([
            'error' => 'Failed to save show.'
        ]);
    }
    public function updateIsPopular(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'popular' => 'required|boolean'
        ]); 
        $show = Show::findOrFail($validated['id']);
        $res = $show->update([
            'popular' => $validated['popular']
        ]);
        if($res){
            return response()->json([
                'success' => 'Show updated successflly.',
            ]);
        }
        return response()->json([
            'error' => 'Failed to update show.'
        ]); 
    }
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]); 
        $show = Show::findOrFail($validated['id']);
        $res = $show->delete();
        if($res){
            return response()->json([
                'success' => 'Show deleted successflly.',
            ]);
        }
        return response()->json([
            'error' => 'Failed to delete show.'
        ]); 
    }
}
