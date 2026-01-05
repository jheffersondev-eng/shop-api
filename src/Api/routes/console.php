<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('optimize:api', function () {
    Artisan::call('config:cache');
    Artisan::call('event:cache');
    Artisan::call('route:cache');
    $this->info('✓ API otimizada com sucesso!');
})->purpose('Otimizar a aplicação API (sem compilação de views)');
