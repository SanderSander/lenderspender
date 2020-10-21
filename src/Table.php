<?php

declare(strict_types=1);

namespace Acme;

use Acme\Card\Card;
use Acme\Card\CardType;
use Acme\Card\CardValue;

class Table
{
    /**
     * @var Card[]
     */
    protected array $cards = [];

    /**
     * Add a new card to the table
     *
     * @param Player $player
     * @param Card $card
     */
    public function addCard(Player $player, Card $card): void
    {
        array_push($this->cards, [$player, $card]);
    }

    /**
     * Get all the cards on the table
     *
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Get the total amount of points on the table
     *
     * @return int
     */
    public function getPoints(): int
    {
        $points = 0;
        foreach ($this->cards as $played) {
            $card = $played[1];
            if (CardType::HEARTS()->equals($card->getType())) {
                $points++;
            }
            if (CardType::CLUBS()->equals($card->getType()) &&
                CardValue::JACK()->equals($card->getValue())) {
                $points += 2;
            }
            if (CardType::SPADES()->equals($card->getType()) &&
                CardValue::QUEEN()->equals($card->getValue())) {
                $points += 5;
            }
        }

        return $points;
    }

    /**
     * Get the player that lost this table
     *
     * @return Player
     */
    public function getLosingPlayer(): Player
    {
        // The starting player will always lose, if other players
        // did not have cards of the same type.
        $loser = $this->cards[0][0];
        $card = $this->cards[0][1];

        // Check if we have any higher cards of the same type
        // if so set the new loser
        for ($i = 1; $i < count($this->cards); $i++) {
            $currentCard = $this->cards[$i][1];
            if ($card->getType()->equals($currentCard->getType())) {
                if ($currentCard->getValue()->getValue() > $card->getValue()->getValue()) {
                    $loser = $this->cards[$i][0];
                    $card = $currentCard;
                }
            }
        }

        return $loser;
    }

    /**
     * Return the played card by given player, or null if player does not have cards on the table.
     *
     * @param Player $player
     * @return Card|null
     */
    public function getPlayedCard(Player $player): ?Card
    {
        foreach ($this->cards as $played) {
            if ($played[0] === $player) {
                return $played[1];
            }
        }

        return null;
    }
}
