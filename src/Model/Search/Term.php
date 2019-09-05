<?php

namespace JobBoard\Model\Search;

final class Term implements Query
{
    /** @var string */
    private $field;

    /** @var string */
    private $value;

    /** @var bool */
    private $negate = false;

    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function negate(): void
    {
        $this->negate = true;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function toArray(): array
    {
        return [
            'bool' => [
                $this->negate
                    ? 'must_not'
                    : 'must' => [
                    [
                        'term' => [
                            $this->field => [
                                'value' => $this->value,
                            ],
                        ],
                    ]
                ],
            ],
        ];
    }
}