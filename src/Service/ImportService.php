<?php

namespace LaravelTool\Kladr\Service;

use DB;
use Illuminate\Support\Str;
use XBase\TableReader;

class ImportService
{
    public function __construct(
        protected string $path
    ) {

    }

    public function import()
    {
        foreach (['ALTNAMES', 'DOMA', 'FLAT', 'KLADR', 'NAMEMAP', 'SOCRBASE', 'STREET'] as $table) {
            $this->importTable($table);
        }
    }

    protected function importTable($tableName)
    {
        $table = new TableReader($this->getDbfFile($tableName.'.DBF'), [
            'encoding' => 'cp866',
        ]);
        $columns = array_keys($table->getColumns());

        $data = [];
        while ($record = $table->nextRecord()) {
            if ($record->isDeleted()) {
                continue;
            }

            $row = [];
            foreach ($columns as $column) {
                $row[$column] = $record->get($column);
            }

            $data[] = $row;

            if (count($data) == 1000) {
                DB::connection(config('kladr.database.connection'))->table($this->getTable($tableName))->insert($data);
                $data = [];
            }
        }

        if (count($data)) {
            DB::connection(config('kladr.database.connection'))->table($this->getTable($tableName))->insert($data);
        }
    }

    protected function getDbfFile(string $filename): string
    {
        return $this->path.DIRECTORY_SEPARATOR.$filename;
    }

    protected function getTable($table): string
    {
        return config('kladr.database.table_prefix').Str::lower($table);
    }
}
