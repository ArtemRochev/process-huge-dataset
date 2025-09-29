<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Cache\CacheInterface;

class HugeDatasetSupplier
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private string $projectDir,
        #[Autowire('@cache.app')]
        private CacheInterface $cache
    )
    {}

    public function get(): array
    {
        return $this->cache->get('dataset', function () {
            return $this->process();
        });
    }
    private function process(): array
    {
        sleep(10);

        return json_decode((new Filesystem())->readFile(
            sprintf('%s/%s', $this->projectDir, 'data.json')
        ));
    }
}
