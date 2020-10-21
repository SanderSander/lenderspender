<?php

declare(strict_types=1);

namespace Acme;

use Acme\Card\Card;

class Player
{
    protected string $name;
    protected int $points = 0;
    protected array $cards = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString():string
    {
        return $this->name;
    }

    /**
     * Set a new hand of cards
     *
     * @param array $cards
     */
    public function setCards(array $cards):void
    {
        $this->cards = $cards;
    }

    /**
     * Get card at index
     *
     * @param int $index
     * @return Card
     */
    public function getCard(int $index):Card
    {
        return $this->cards[$index];
    }

    /**
     * Get total points of player
     *
     * @return int
     */
    public function getPoints():int
    {
        return $this->points;
    }

    /**
     * Add new points to player
     *
     * @param int $points
     */
    public function addPoints(int $points):void
    {
        $this->points += $points;
    }

    /**
     * Check if player still has cards in his hands
     *
     * @return bool
     */
    public function hasCards():bool
    {
        return !empty($this->cards);
    }

    /**
     * Let the player play a card on the given table.
     *
     * @param Table $table
     */
    public function playCard(Table $table):void
    {
        $cards = $table->getCards();
        $card = null;

        // No cards on the table so just play a card.
        if (empty($cards)) {
            $table->addCard($this, array_pop($this->cards));
            return;
        }

        $type = $cards[0][1]->getType();

        // Pick lowest matching suite card
        foreach ($this->cards as $currentCard) {
            if ($currentCard->getType()->equals($type)) {
                if ($card === null ||
                    $card->getValue()->getValue() > $currentCard->getValue()->getValue()) {
                    $card = $currentCard;
                }
            }
        }

        // Remove lower card from hand, or when no matching lower card pick random card.
        if ($card !== null) {
            unset($this->cards[array_search($card, $this->cards, true)]);
        } else {
            $card = array_pop($this->cards);
        }

        $table->addCard($this, $card);
    }
}
