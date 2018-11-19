<?php

namespace App\Jobs;

use App\Models\DownloaderData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;

class DownloadFiles implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $downloader_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DownloaderData $downloader_data) {
        $this->downloader_data = $downloader_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $url = $this->downloader_data->source_url;
        try {
            $info = pathinfo($url);
            $name = $info['basename'];
            $contents = file_get_contents($url);
            $save_path = 'downloader/' . uniqid('', true) . '.' . $info['extension'];
            Storage::put($save_path, $contents);
            $this->downloader_data->local_path = $save_path;
            $this->downloader_data->filename = $name;
            $this->downloader_data->status = DownloaderData::STATUS_DOWNLOADED;
        } catch (\Exception $exc) {
            $this->downloader_data->status = DownloaderData::STATUS_FAILED;
        }
        
        $this->downloader_data->save();
    }

}
