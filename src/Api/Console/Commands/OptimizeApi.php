<?php

namespace Src\Api\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class OptimizeApi extends Command
{
    protected $signature = 'optimize:api';
    protected $description = 'Otimizar a aplicação API (sem compilação de views)';

    public function handle(): int
    {
        $this->info('Caching framework bootstrap, configuration, and metadata.');

        Artisan::call('config:cache');
        Artisan::call('event:cache');
        Artisan::call('route:cache');

        $this->info('✓ API otimizada com sucesso!');
        return 0;
    }
}
