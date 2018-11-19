<?php

namespace App\Observers;

use App\Models\DownloaderData;
use Storage;

class DownloaderDataObserver
{
    public function deleted(DownloaderData $donwloaded_data)
    {
        if ($donwloaded_data->local_path) {
            Storage::delete($donwloaded_data->local_path);
        }
    }
}
