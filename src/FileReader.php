<?php

declare(strict_types=1);

namespace App;


class FileReader
{
    public function read(string $filePath): \Generator
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File $filePath does not exist");
        }

        $fd = fopen($filePath, "r");

        if ($fd) {
            while (($line = fgets($fd)) !== false) {
                yield $line;
            }

            fclose($fd);
        }
    }
}
