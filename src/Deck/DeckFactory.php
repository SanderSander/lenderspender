<?php

declare(strict_types=1);

namespace Acme\Deck;

use Acme\Card\Card;
use Acme\Card\CardType;
use Acme\Card\CardValue;

class DeckFactory implements DeckFactoryInterface
{
    protected bool $shuffle;

    public function __construct(bool $shuffle = false)
    {
        $this->shuffle = $shuffle;
    }

    /**
     * Create a full deck with unique cards
     *
     * @return Deck
     */
    public function make():Deck
    {

        // Add all unique cards for a full deck
        $cards = [];
        foreach (CardType::values() as $type) {
            foreach (CardValue::values() as $value) {
                array_push($cards, new Card($type, $value));
            }
        }

        $deck = new Deck($cards);
        if ($this->shuffle) {
            $deck->shuffle();
        }

        return $deck;
    }
}
