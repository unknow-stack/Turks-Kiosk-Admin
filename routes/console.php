<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('kiosk:about', function () {
    $this->info('Turks Kiosk Web Admin is ready.');
})->purpose('Display the Turks kiosk project status');
