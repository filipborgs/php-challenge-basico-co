<?php

namespace App\Jobs;

use App\Contracts\ProductContract;
use App\Exceptions\ValidationException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessProductJson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProductContract $repository)
    {
        $str = Storage::get($this->path);
        $json = json_decode($str, true);

        foreach ($json as $el) {
            if (is_object($el) || is_array($el)) {
                try {
                    $repository->save((array) $el);
                } catch (ValidationException $e) {
                    Log::info($e->getMessage());
                }
            }
        }

        Storage::delete($this->path);
    }
}
