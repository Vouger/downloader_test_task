<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloaderData;

class DownloaderController extends Controller {

    public function index(Request $request) {
        return view('downloader.index', [
            'downloader_data' => DownloaderData::all(),
            'url_error' => $request->session()->pull('url_error'),
            'success' => $request->session()->pull('success')
        ]);
    }
    
    public function load_table(Request $request) {
        return view('downloader.table', [
            'downloader_data' => DownloaderData::all()
        ]);
    }

    public function add_url(Request $request) {
        $url = $request->get('url');
        $url_status = filter_var($url, FILTER_VALIDATE_URL);

        if (!$url_status) {
            $request->session()->put('url_error', true);
        } else {
            DownloaderData::store($url);
            $request->session()->put('success', true);
        }

        return redirect()->route('home');
    }

}
