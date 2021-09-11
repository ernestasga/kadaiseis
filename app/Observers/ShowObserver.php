<?php

namespace App\Observers;

use App\Models\Show;
use Illuminate\Support\Facades\Cache;

class ShowObserver
{
    /**
     * Handle the Show "created" event.
     *
     * @param  \App\Models\Show  $show
     * @return void
     */
    public function created(Show $show)
    {
        $this->clearPopularCache();
    }

    /**
     * Handle the Show "updated" event.
     *
     * @param  \App\Models\Show  $show
     * @return void
     */
    public function updated(Show $show)
    {
        $this->clearPopularCache();
    }

    /**
     * Handle the Show "deleted" event.
     *
     * @param  \App\Models\Show  $show
     * @return void
     */
    public function deleted(Show $show)
    {
        $this->clearPopularCache();
    }

    
    private function clearPopularCache(){
        Cache::forget('popular');
    }
}
