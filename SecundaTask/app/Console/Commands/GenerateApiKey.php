<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate-api-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and store API key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = Str::random(64);

        Storage::disk('local')->put('api_key', $key);

        $this->info('API ключ успешно сгенерирован:');
        $this->newLine();
        $this->line($key);
        $this->newLine();
        $this->info('Ключ хранится в файле storage/app/api_key');

        return Command::SUCCESS;
    }
}
