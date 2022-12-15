<?php

namespace LaravelTool\Kladr\Console;

use Illuminate\Console\Command;
use LaravelTool\Kladr\Event\UpdateComplete;
use LaravelTool\Kladr\Service\FiasService;
use LaravelTool\Kladr\Service\ImportService;

class UpdateCommand extends Command
{
    protected $signature = 'kladr:update';

    protected $description = 'KLADR install full database';

    public function handle(
        FiasService $fiasService
    ): int {

        $version = $fiasService->getLastVersion();
        $filename = $fiasService->downloadVersion($version['url'], $version['version_id']);
        $extractPath = $fiasService->extractFiles($filename);

        $importService = new ImportService($extractPath);
        $importService->import();

        UpdateComplete::dispatch();

        return self::SUCCESS;
    }


}
