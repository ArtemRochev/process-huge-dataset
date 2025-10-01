<?php

namespace App\Response;

use App\DTO\Dataset;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DatasetResponse extends JsonResponse
{
    public function __construct(Dataset $dataset)
    {
        $data = json_decode($dataset->getData(), true);
        $status = Response::HTTP_OK;
        $headers = [];

        if ($dataset->isStale()) {
            $headers = ['X-Cache-Status' => 'STALE'];
        }

        parent::__construct($data, $status, $headers);
    }
}
