# Laravel KLADR import module
# Install
```bash
composer require laravel-tool/kladr
```
# Configure
```php
return [
    'wsdl' => 'http://fias.nalog.ru/WebServices/Public/DownloadService.asmx?WSDL',

    'database' => [
        'connection' => null,
        'table_prefix' => 'kladr_',
    ],

    'temporary_path' => storage_path('kladr'),

];
```
