<?php

namespace App\Handlers\Events;

use Log;
//use App\Events\illuminate.query;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueryLogTracker
{
    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  illuminate.query  $event
     * @return void
     */
    public function handle($query, $bindings)
    {
        //
        Log::debug('EXECUTE SQL:[' . $query . ']', ['BINDINGS' => json_encode($bindings)]);
    }
}
