<?php

declare(strict_types=1);

namespace Acme\Deck;

use Acme\Card\Card;

class Deck
{
    /**
     * @var Card[]
     */
    protected array $cards = [];

    /**
     * Deck constructor.
     * @param Card[] $cards
     */
    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    /**
     * Shuffle the deck
     */
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->cards);
    }

    /**
     * Take cards from the deck
     *
     * @param int $count The total number of cards to take
     *
     * @return Card[]
     */
    public function take(int $count): array
    {
        // TODO throw exception if the deck doesn't contain enough cards

        return array_splice($this->cards, 0, $count);
    }
}
