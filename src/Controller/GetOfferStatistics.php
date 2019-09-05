<?php

namespace JobBoard\Controller;

use JobBoard\Repository\Offers;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetOfferStatistics
{
    /** @var Offers */
    private $jobs;

    public function __construct(Offers $jobs)
    {
        $this->jobs = $jobs;
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'avg_salary' => $this->jobs->avgSalary(),
                'company_with_most_offers' => $this->jobs->topCompany(),
                'amount_of_jobs_in_cities' => $this->jobs->jobsInCities(),
            ]
        );
    }
}
