<?php

namespace App\DTO;

class Dataset
{
    public function __construct(private string $data, private int $ex)
    {}

    public function getData(): string
    {
        return $this->data;
    }

    public function getEx(): int
    {
        return $this->ex;
    }

    public function isStale(): bool
    {
        return time() > $this->ex;
    }
}
