<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\VideoViewer;

class IncreaseCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VideoViewer $event)
    {
        if (!session()->has('videoIsVisited')) {
            $this->updateViewr($event->video);
        } else {
            return false;
        }
    }


    function updateViewr($video)
    {
        $video->viewers = $video->viewers + 1;
        $video->save();
        session()->put('videoIsVisited', $video->id);
    }
}
