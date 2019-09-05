<?php

namespace JobBoard\Controller;

use JobBoard\Repository\Offers;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetOffers
{
    /** @var Offers */
    private $jobs;

    public function __construct(Offers $jobs)
    {
        $this->jobs = $jobs;
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->jobs->all());
    }
}
