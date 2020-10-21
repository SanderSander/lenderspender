<?php

declare(strict_types=1);

namespace Acme\Card;

use MyCLabs\Enum\Enum;

/**
 * Card values, 11 equals jack, 12 equals queen and 13 equals king.
 *
 * @method static CardValue SEVEN()
 * @method static CardValue EIGHT()
 * @method static CardValue NINE()
 * @method static CardValue TEN()
 * @method static CardValue JACK()
 * @method static CardValue QUEEN()
 * @method static CardValue KING()
 */
class CardValue extends Enum
{
    private const SEVEN = 7;
    private const EIGHT = 8;
    private const NINE = 9;
    private const TEN = 10;
    private const JACK = 11;
    private const QUEEN = 12;
    private const KING = 13;
}
