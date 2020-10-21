<?php

declare(strict_types=1);

namespace Acme\Deck;

interface DeckFactoryInterface
{
    public function make():Deck;
}
