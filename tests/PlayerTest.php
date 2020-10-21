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
 * @covers Player
 */
final class PlayerTest extends TestCase
{
    /**
     * Test if player plays a card when the table is empty
     */
    public function testIfPlayerPlaysCardOnEmptyTable() {
        $player = new Player('Foo');
        $card = new Card(CardType::SPADES(), CardValue::QUEEN());
        $player->setCards([$card]);

        // Mock the table, and expect that the player adds his card on the table
        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('addCard')
            ->with($this->equalTo($player), $this->equalTo($card));

        $player->playCard($table);
    }

    /**
     * Test if players plays his lowest matching card.
     */
    public function testIfPlayerPlaysLowestMatchingCard() {
        $player = new Player('Foo');
        $cards = [
            new Card(CardType::SPADES(), CardValue::EIGHT()),
            new Card(CardType::SPADES(), CardValue::JACK())
        ];
        $player->setCards($cards);

        // Mock the table, and expect that the player adds the lowest card on the table
        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('addCard')
            ->with($this->equalTo($player), $this->equalTo($cards[0]));

        // Return a played card of the same type
        $table->method('getCards')
            ->willReturn([
                [$this->createMock(Player::class),
                new Card(CardType::SPADES(), CardValue::EIGHT())]
            ]);

        $player->playCard($table);
    }

    /**
     * Test if player plays a card, when it doesn't have a matching card.
     */
    public function testIfPlayerPlaysNoMatchingCard() {
        $player = new Player('Foo');
        $cards = [
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::JACK())
        ];
        $player->setCards($cards);

        // Mock the table, and expect that the player adds the lowest card on the table
        $table = $this->createMock(Table::class);
        $table->expects($this->once())
            ->method('addCard')
            ->with($this->equalTo($player), $this->equalTo($cards[1]));

        // Return a played card of the same type
        $table->method('getCards')
            ->willReturn([
                [$this->createMock(Player::class),
                    new Card(CardType::DIAMONDS(), CardValue::EIGHT())]
            ]);

        $player->playCard($table);
    }
}
