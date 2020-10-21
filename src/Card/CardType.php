<?php

declare(strict_types=1);

namespace Acme\Card;

use MyCLabs\Enum\Enum;

/**
 * @method static CardType CLUBS()
 * @method static CardType DIAMONDS()
 * @method static CardType HEARTS()
 * @method static CardType SPADES()
 */
class CardType extends Enum
{
    private const CLUBS = '♣';
    private const DIAMONDS = '♦';
    private const HEARTS = '♥';
    private const SPADES = '♠';
}
