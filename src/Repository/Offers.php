<?php

namespace JobBoard\Repository;

interface Offers
{
    public function all(): array;

    public function byId(int $id): ?array;

    public function topViewed(): array;

    public function recentlyAdded(): array;

    public function avgSalary(): array;

    public function topCompany(): array;

    public function jobsInCities(): array;

    public function findByCityName(string $cityName): array;

    public function findBySkillName(string $skillName): array;
}
