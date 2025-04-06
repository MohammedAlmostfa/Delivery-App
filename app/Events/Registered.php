<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Registered
{
    use Dispatchable, SerializesModels;

    public $data;
    public $key;

    /**
     * Create a new event instance.
     *
     * @param  array  $data
     * @param  string  $key
     * @return void
     */
    public function __construct($data, $key)
    {
        Log::debug('Event fired', ['data' => $data]);

        $this->data = $data;
        $this->key = $key;
    }
}
