<?php

namespace JobBoard\Repository;

use GuzzleHttp\ClientInterface;
use JobBoard\Model\Hits;
use Psr\Log\LoggerInterface;

final class ElasticOffers implements Offers
{
    /** @var ClientInterface */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function all(): array
    {
        $query = [
            'query' => [
                'match_all' => [],
            ],
        ];

        $response = $this->client->request('POST', '_search', [
            'json' => $query
        ]);

        $body = $response->getBody()->getContents();
        $hits = new Hits(json_decode($body, true));

        return $hits->results();
    }

    public function byId(int $id): ?array
    {

    }

    public function topViewed(): array
    {

    }

    public function recentlyAdded(): array
    {

    }

    public function avgSalary(): array
    {

    }

    public function topCompany(): array
    {

    }

    public function jobsInCities(): array
    {

    }

    public function findByCityName(string $cityName): array
    {

    }

    public function findBySkillName(string $skillName): array
    {

    }
}
