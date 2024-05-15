<?php

declare(strict_types=1);

namespace App\Application\Builder;

use Illuminate\Support\LazyCollection;

class FileReader
{
    public function __construct()
    {
    }

    public function readCsvFile(string $filename): LazyCollection
    {
        return LazyCollection::make(function () use ($filename) {
            $file = fopen($filename, 'r');
            while ($data = fgetcsv($file)) {
                yield $data;
            }
            fclose($file);
        });
    }
}
