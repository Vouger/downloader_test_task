<?php

namespace App\Console\Commands;

use App\Models\DownloaderData;
use Illuminate\Console\Command;

class DownloaderList extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloader:list {--full}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists downloader queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $headers = ['Source url', 'Download link', 'Status name'];
        $full_list = $this->option('full');
        
        $downloaded_data = DownloaderData::all()->map(function ($data) use ($full_list) {
            $source_url_truncated = strlen($data->source_url) > 50 ? substr($data->source_url, 0, 50).'...' : $data->source_url;
            
            return [
                $full_list ? $data->source_url : $source_url_truncated,
                route('download_url', ['id' => $data->id]),
                $data->status_name
            ];
        });

        $this->table($headers, $downloaded_data);
    }

}
