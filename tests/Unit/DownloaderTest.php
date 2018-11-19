<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\DownloaderData;
use Illuminate\Http\UploadedFile;
use Storage;

class DownloaderTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDownloadByUrl() {
        $filename = 'document.pdf';
        $fake_file = UploadedFile::fake()->create($filename, 1);
        Storage::put($filename, file_get_contents($fake_file));
        $url = Storage::path($filename);
        $donwloaded_data = DownloaderData::store($url);

        //time to download
        sleep(5);

        //check database
        $this->assertDatabaseHas('downloader_data', [
            'source_url' => $url,
            'filename' => $filename,
            'status' => DownloaderData::STATUS_DOWNLOADED
        ]);

        $updated_data = DownloaderData::find($donwloaded_data->id);

        //check downloaded file
        Storage::assertExists($updated_data->local_path);

        $updated_data->delete();
        Storage::delete($filename);
    }

    public function testDownloaderApi() {
        $valid_url = 'http://google.com';
        $invalid_url = 'htp:/invalidurl';

        $response_valid = $this->json('POST', '/api/downloader', ['url' => $valid_url]);

        $response_valid
                ->assertStatus(201)
                ->assertJson([
                    'source_url' => $valid_url,
                    'status_name' => 'Queued'
        ]);

        $content = $response_valid->decodeResponseJson();

        //time to download
        sleep(5);
        
        $response_invalid = $this->json('POST', '/api/downloader', ['url' => $invalid_url]);
        
        $response_invalid->assertStatus(422);
        
        $response_get = $this->json('GET', '/api/downloader');
        
        $response_get->assertStatus(200);
        
        $response_show_valid = $this->json('GET', '/api/downloader/' . $content['id']);
        
        $response_show_valid->assertStatus(200);
        
        $response_show_invalid = $this->json('GET', '/api/downloader/0');
        
        $response_show_invalid->assertStatus(404);
        
        DownloaderData::find($content['id'])->delete();
    }

}
