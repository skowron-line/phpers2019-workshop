<?php

namespace JobBoard\Controller;

use JobBoard\Repository\Offers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetOffer
{
    /** @var Offers */
    private $jobs;

    public function __construct(Offers $jobs)
    {
        $this->jobs = $jobs;
    }

    public function __invoke(int $id): JsonResponse
    {
        $offer = $this->jobs->byId($id);
        if ($offer) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($offer);
    }
}
