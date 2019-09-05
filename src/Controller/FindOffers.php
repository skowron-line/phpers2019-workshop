<?php

namespace JobBoard\Controller;

use JobBoard\Repository\Offers;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FindOffers
{
    /** @var Offers */
    private $offers;

    public function __construct(Offers $offers)
    {
        $this->offers = $offers;
    }

    public function inCity(string $cityName): JsonResponse
    {
        $offers = $this->offers->findByCityName($cityName);

        return new JsonResponse($offers);
    }

    public function bySkills(string $skillName): JsonResponse
    {
        $offers = $this->offers->findBySkillName($skillName);

        return new JsonResponse($offers);
    }
}
