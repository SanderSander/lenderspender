<?php

declare(strict_types=1);

namespace Acme;

interface RandomGeneratorInterface
{
    public function random(int $min = 0, ?int $max = null):int;
}
