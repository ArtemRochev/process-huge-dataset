<?php

namespace App\Controller;

use App\Exception\InProgressException;
use App\Service\DatasetProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HugeDatasetController
{
    #[Route('/process-huge-dataset', methods: ['GET'])]
    public function processHugeDataset(DatasetProcessor $datasetSupplier): JsonResponse
    {
        $dataset = $datasetSupplier->getDatasetFromCache();

        if (!$dataset || $dataset->isStale()) {
            try {
                $dataset = $datasetSupplier->getDataset();
            } catch (InProgressException $e) {
                if ($dataset) {
                    return new JsonResponse(
                        json_decode($dataset->getData(), true),
                        Response::HTTP_OK,
                        ['X-Cache-Status' => 'STALE']
                    );
                }

                return new JsonResponse([], Response::HTTP_ACCEPTED);
            }
        }


        return new JsonResponse(json_decode($dataset->getData(), true));
    }
}
