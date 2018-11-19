<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DownloaderData;

class DownloaderAdd extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downloader:add {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add URL to downloader queue';

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
        $url = $this->argument('url');
        $url_status = filter_var($url, FILTER_VALIDATE_URL);
        
        if (!$url_status) {
            $this->error('Invalid URL!');
        } else {
            DownloaderData::store($url);
            $this->info('URL added to queue');
        }
    }

}
