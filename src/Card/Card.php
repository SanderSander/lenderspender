<?php

declare(strict_types=1);

namespace Acme\Card;

class Card
{
    protected CardType $type;

    protected CardValue $value;

    public function __construct(CardType $type, CardValue $value) {
        $this->type = $type;
        $this->value = $value;
    }

    public function __toString()
    {
        $value = $this->value->getValue();

        switch ($value) {
            case 11:
                $value = 'J';
                break;
            case 12:
                $value = 'Q';
                break;
            case 13:
                $value = 'K';
                break;
        }

        return $this->type->getValue() . $value;
    }

    public function getType():CardType
    {
        return $this->type;
    }

    public function getValue():CardValue
    {
        return $this->value;
    }
}
