<?php

namespace LaravelTool\Kladr\Service;

use SoapClient;
use File;
use Symfony\Component\Process\Process;

class FiasService
{
    public function getLastVersion(): array
    {
        $soapClient = new SoapClient(config('kladr.wsdl'));

        $response = $soapClient->GetLastDownloadFileInfo([]);

        return [
            'version_id' => (int) $response->GetLastDownloadFileInfoResult->VersionId,
            'url' => $response->GetLastDownloadFileInfoResult->Kladr47ZUrl
        ];
    }

    public function downloadVersion(string $url, int $versionId): string
    {
        $response = \Http::get($url);
        $extractPath = $this->getExtractPath();

        File::makeDirectory($extractPath, 0755, true, true);

        $filename = $this->getDownloadFilename($versionId);
        File::put($filename, $response->body());

        return $filename;
    }

    public function extractFiles($filename): string
    {
        $process = new Process([
            '/usr/bin/7zr',
            'x',
            $filename,
            '-o'.$this->getExtractPath(),
        ]);

        $process->mustRun();

        return $this->getExtractPath();
    }

    protected function getDownloadFilename(int $versionId): string
    {
        return config('kladr.temporary_path').DIRECTORY_SEPARATOR.$versionId.'.7z';
    }

    protected function getExtractPath(): string
    {
        return config('kladr.temporary_path').DIRECTORY_SEPARATOR.'extracted';
    }
}
