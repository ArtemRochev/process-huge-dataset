<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class DataProvider
{
    public function __construct(private string $projectDir)
    {}

    public function getData(): string
    {
        sleep(10);

        return (new Filesystem())->readFile(
            sprintf('%s/%s', $this->projectDir, 'data.json')
        );
    }
}
