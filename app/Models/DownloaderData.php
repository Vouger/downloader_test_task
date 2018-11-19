<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\DownloadFiles;

class DownloaderData extends Model {

    const STATUS_QUEUED = 0;
    const STATUS_DOWNLOADED = 1;
    const STATUS_FAILED = 2;

    protected $table = 'downloader_data';
    protected $fillable = ['source_url', 'filename'];
    protected $appends = ['status_name'];
    protected $hidden = ['status', 'local_path'];

    public static function store($url) {
        $downloader_data = self::create(['source_url' => $url]);
        DownloadFiles::dispatch($downloader_data);
        return $downloader_data;
    }

    public function getStatusNameAttribute($value) {
        $status_name = '';
        switch (object_get($this, 'status')) {
            case self::STATUS_QUEUED:
                $status_name = 'Queued';
                break;

            case self::STATUS_DOWNLOADED:
                $status_name = 'Downloaded';
                break;

            case self::STATUS_FAILED:
                $status_name = 'Failed';
                break;
        }
        return $status_name;
    }

}
