<?php
declare(strict_types=1);

namespace Tests;

use Acme\Card\Card;
use Acme\Card\CardType;
use Acme\Card\CardValue;
use Acme\Deck\Deck;
use Acme\Deck\DeckFactoryInterface;
use Acme\Game;
use Acme\Player;
use Acme\RandomGeneratorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Acme\Game
 */
final class GameTest extends TestCase
{
    /**
     * Test game initialization
     */
    public function testGameInitialization() {
        $deckFactory = $this->createMock(DeckFactoryInterface::class);
        $randomGenerator = $this->createMock(RandomGeneratorInterface::class);

        // Expect the random generator to be called, we need a random starting player
        $randomGenerator->expects($this->once())->method('random')->willReturn(2);

        new Game([], $deckFactory, $randomGenerator);
    }

    /**
     * Test if the cards are distributed among the players
     */
    public function testCardShuffle() {
        $deckFactory = $this->createMock(DeckFactoryInterface::class);
        $randomGenerator = $this->createMock(RandomGeneratorInterface::class);

        // We need a random starting player
        $randomGenerator->method('random')->willReturn(2);

        // Expect the deck factory to be called, and return a deck with 6 cards
        $deckFactory->expects($this->once())->method('make')->willReturn(new Deck([
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::QUEEN()),
        ]));

        // Create the player mocks and expect the player to receive 2 cards
        $player1 = $this->createMock(Player::class);
        $player1->expects($this->once())->method('setCards')->with([
            new Card(CardType::SPADES(), CardValue::QUEEN()),
            new Card(CardType::SPADES(), CardValue::QUEEN()),
        ]);
        $player2 = $this->createMock(Player::class);
        $player3 = $this->createMock(Player::class);

        $game = new Game([$player1, $player2, $player3], $deckFactory, $randomGenerator);
        $game->distributeCards();
    }

    /**
     * Test detection of when the game is finished, and if the losing player is picked correctly
     */
    public function testFinishedGame() {
        $deckFactory = $this->createMock(DeckFactoryInterface::class);
        $randomGenerator = $this->createMock(RandomGeneratorInterface::class);

        $player1 = $this->createMock(Player::class);
        $player1->method('getPoints')->willReturn(20);
        $player2 = $this->createMock(Player::class);
        $player2->method('getPoints')->willReturn(50);
        $player3 = $this->createMock(Player::class);
        $player3->method('getPoints')->willReturn(30);

        $game = new Game([$player1, $player2, $player3], $deckFactory, $randomGenerator);
        $this->assertEquals(true, $game->finished());
        $this->assertEquals($player2, $game->getLoser());
    }

    /**
     * Test one play round
     */
    public function testSingleRound() {
        $deckFactory = $this->createMock(DeckFactoryInterface::class);
        $randomGenerator = $this->createMock(RandomGeneratorInterface::class);

        $player1 = new Player('Player1');
        $player1->setCards([new Card(CardType::HEARTS(), CardValue::KING())]);
        $player2 = new Player('Player2');
        $player2->setCards([new Card(CardType::HEARTS(), CardValue::QUEEN())]);
        $player3 = new Player('Player3');
        $player3->setCards([new Card(CardType::HEARTS(), CardValue::JACK())]);

        // We need a random starting player
        $randomGenerator->method('random')->willReturn(1);

        $game = new Game([$player1, $player2, $player3], $deckFactory, $randomGenerator);
        $table = $game->play();

        $this->assertEquals($player1, $table->getLosingPlayer(), 'We expect player 1 to lose');
        $this->assertEquals(3, $table->getPoints(), 'We expect 3 points on the table');
        $this->assertEquals($player2, $table->getCards()[0][0], 'We expect player2 to begin');
    }
}
