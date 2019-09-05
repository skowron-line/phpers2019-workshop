<?php

namespace JobBoard\Model;

final class Hits
{
    /** @var int */
    private $total;

    /** @var float */
    private $maxScore;

    /** @var array */
    private $results;

    public function __construct(array $data)
    {
        $this->total = $data['hits']['total']['value'];
        $this->maxScore = $data['hits']['max_score'];

        foreach ($data['hits']['hits'] as $hit) {
            $this->results[] = $hit['_source'];
        }
    }

    public function total(): int
    {
        return $this->total;
    }

    public function maxScore(): float
    {
        return $this->maxScore;
    }

    public function results(): array
    {
        return $this->results;
    }
}
