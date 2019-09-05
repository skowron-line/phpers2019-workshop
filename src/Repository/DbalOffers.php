<?php

namespace JobBoard\Repository;

use Doctrine\DBAL\Driver\Connection;

final class DbalOffers implements Offers
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function all(): array
    {
        $sql =<<<SQL
SELECT * FROM offers 
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function byId(int $id): ?array
    {
        $sql  =<<<SQL
SELECT * FROM offers WHERE id = :id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function topViewed(): array
    {
        $sql =<<<SQL
SELECT * FROM offers ORDER BY views_count DESC LIMIT 10;
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function recentlyAdded(): array
    {
        $sql =<<<SQL
SELECT * FROM offers ORDER BY added_at DESC LIMIT 10;
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function avgSalary(): array
    {
        $sql =<<<SQL
SELECT AVG(salary_to - salary_from) FROM offers ORDER BY views_count DESC LIMIT 10;
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function topCompany(): array
    {
        $sql =<<<SQL
SELECT companies.name, COUNT(offers_companies.offer_id) AS offers FROM offers_companies, companies
WHERE companies.id = offers_companies.company_id
GROUP BY companies.id
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function jobsInCities(): array
    {
        $sql =<<<SQL
SELECT cities.name, COUNT(offers_cities.offer_id) AS offers FROM offers_cities, cities
WHERE cities.id = offers_cities.city_id
GROUP BY cities.id
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByCityName(string $cityName): array
    {
        return [];
    }

    public function findBySkillName(string $skillName): array
    {
        return [];
    }
}
