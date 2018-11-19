# Installation steps:
1) **git clone git@github.com:Vouger/downloader_test_task.git**
2) **composer install**
3) create and config .env file (database config)
4) config .env.testing file
5) **php artisan queue:listen**
6) **php artisan serve**


# Usage
## Command line
- **php artisan downloader:add {url}** - add url to downloader queue
- **php artisan downloader:list {--full}** - print list of downloader data. {--full} key to show full urls.

## Api
- **GET /api/downloader** - get all downloader data
- **GET /api/downloader/{id}** - download file by id
- **POST /api/downloader/** - add url to downloader queue. POST param name - **url**

## Testing
- **/tests/Unit/DownloaderTest.php** - tests for downloading process and API methods
