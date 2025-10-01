<?php

namespace App\Service;

use Redis;
use App\DTO\Dataset;
use App\Exception\InProgressException;
use Symfony\Component\Lock\LockFactory;

class DatasetProcessor
{
    const CACHE_TTL = 60;
    const CACHE_KEY = 'dataset';
    const LOCK_KEY = 'dataset-process';

    public function __construct(
        private DataProvider $dataProvider,
        private LockFactory $lockFactory,
        private Redis $redis,
    )
    {}

    public function getDataset(): Dataset
    {
        $lock = $this->lockFactory->createLock(self::LOCK_KEY, null, false);

        try {
            if (!$lock->acquire()) {
                throw new InProgressException();
            }

            $dataset = new Dataset(
                $this->dataProvider->getData(),
                time() + self::CACHE_TTL
            );

            $this->redis->hSet(self::CACHE_KEY, 'data', $dataset->getData());
            $this->redis->hSet(self::CACHE_KEY, 'ex', $dataset->getEx());
        } finally {
            $lock->release();
        }

        return $dataset;
    }

    public function getDatasetFromCache(): ?Dataset
    {
        if (!$this->redis->exists(self::CACHE_KEY)) {
            return null;
        }

        return new Dataset(
            $this->redis->hGet(self::CACHE_KEY, 'data'),
            $this->redis->hGet(self::CACHE_KEY, 'ex')
        );
    }
}
