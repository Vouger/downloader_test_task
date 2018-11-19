<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloaderData;
use Storage;

class DownloaderApi extends Controller {

    public function index() {
        return DownloaderData::all();
    }

    public function show(DownloaderData $downloader_data) {
        if ($downloader_data->local_path) {
            return Storage::download($downloader_data->local_path, $downloader_data->filename);
        } else {
            return response()->json(['data' => 'Not Found!'], 404);
        }
    }

    public function store(Request $request) {
        $url = $request->get('url');
        $url_status = filter_var($url, FILTER_VALIDATE_URL);

        if (!$url_status) {
            return response()->json(['data' => 'Invalid URL!'], 422);
        } else {
            $downloader_data = DownloaderData::store($url);

            return response()->json($downloader_data, 201);
        }
    }

}
