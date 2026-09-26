<?php

use Illuminate\Support\Facades\Route;

Route::get('media/{path}', function (string $path) {
    abort_if(str_contains($path, '..'), 404);
    $file = storage_path('app/public/'.$path);
    abort_unless(is_file($file), 404);
    return response()->file($file);
})->where('path', '.*');

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/admin.php';

require __DIR__.'/member.php';

require __DIR__.'/visitor.php';
