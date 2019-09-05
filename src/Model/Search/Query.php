<?php

namespace JobBoard\Model\Search;

interface Query
{
    public function toArray(): array;

    public function field(): string;

    public function negate(): void;
}
