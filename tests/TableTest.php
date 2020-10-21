<?php
declare(strict_types=1);

namespace Tests;

use Acme\Card\Card;
use Acme\Card\CardType;
use Acme\Card\CardValue;
use Acme\Player;
use Acme\Table;
use PHPUnit\Framework\TestCase;

/**
 * @covers Table
 */
final class TableTest extends TestCase
{
    /**
     * Test if the points on the table are calculated correctly
     *
     * Card of heart suit:  1 point
     * Jack of clubs:       2 points
     * Queen of spades:     5 points
     */
    public function testPointsOnTableCalculation()
    {
        $player = $this->createMock(Player::class);
        $table = new Table();

        $table->addCard($player, new Card(CardType::HEARTS(), CardValue::SEVEN()));
        $table->addCard($player, new Card(CardType::HEARTS(), CardValue::KING()));
        $table->addCard($player, new Card(CardType::CLUBS(), CardValue::JACK()));
        $table->addCard($player, new Card(CardType::SPADES(), CardValue::QUEEN()));
        $table->addCard($player, new Card(CardType::DIAMONDS(), CardValue::QUEEN()));
        $table->addCard($player, new Card(CardType::DIAMONDS(), CardValue::KING()));

        $this->assertEquals(9, $table->getPoints());
    }

    /**
     * Test if the right player loses the current table
     */
    public function testLosingPlayer()
    {
        $player1 = $this->createMock(Player::class);
        $player2 = $this->createMock(Player::class);
        $player3 = $this->createMock(Player::class);
        $table = new Table();

        $table->addCard($player1, new Card(CardType::HEARTS(), CardValue::QUEEN()));
        $table->addCard($player2, new Card(CardType::HEARTS(), CardValue::SEVEN()));
        $table->addCard($player3, new Card(CardType::SPADES(), CardValue::KING()));

        $this->assertEquals($player1, $table->getLosingPlayer());
    }
}
