<?php

namespace App\Controller;

use App\Service\HugeDatasetSupplier;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HugeDatasetController
{
    #[Route('/process-huge-dataset', methods: ['GET'])]
    public function processHugeDataset(HugeDatasetSupplier $datasetSupplier): JsonResponse
    {
        $data = $datasetSupplier->get();

        return new JsonResponse($data);
    }
}
