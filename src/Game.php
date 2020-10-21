<?php

declare(strict_types=1);

namespace Acme;

use Acme\Deck\DeckFactoryInterface;

class Game
{
    /**
     * @var Player[]
     */
    private array $players;

    private DeckFactoryInterface $deckFactory;

    private int $startingPlayer;

    private RandomGeneratorInterface $randomGenerator;

    public function __construct(
        array $players,
        DeckFactoryInterface  $deckFactory,
        RandomGeneratorInterface $randomGenerator
    ) {
        $this->players = $players;
        $this->deckFactory = $deckFactory;
        $this->randomGenerator = $randomGenerator;

        // Roll the dice for the starting player
        $this->startingPlayer = $this->randomGenerator->random(0, count($this->players) - 1);
    }

    /**
     * Distribute cards from the a new deck to all the players
     */
    public function distributeCards(): void
    {
        $deck = $this->deckFactory->make();

        // Distribute all cards over the players
        $take = $deck->count() / count($this->players);
        foreach ($this->players as $player) {
            $player->setCards($deck->take($take));
        }
    }

    /**
     * Play a single round, and return the played table.
     *
     * @return Table
     */
    public function play(): Table
    {
        $table = new Table();

        // Here we iterate through all the players from the starting player
        // Because we don't start at zero we need 2 for loops
        for ($i = $this->startingPlayer; $i < count($this->players); $i++) {
            $player = $this->players[$i];
            $player->playCard($table);
        }
        for ($i = 0; $i < $this->startingPlayer; $i++) {
            $player = $this->players[$i];
            $player->playCard($table);
        }

        // Add points to losing players
        $table->getLosingPlayer()
            ->addPoints($table->getPoints());

        // Move to next player for the following round
        $this->startingPlayer++;
        $this->startingPlayer %= count($this->players);

        return $table;
    }

    /**
     * Return true if the game has finished, otherwise false
     *
     * @return bool
     */
    public function finished(): bool
    {
        foreach ($this->players as $player) {
            if ($player->getPoints() >= 50) {
                return true;
            }
        }

        return false;
    }

    public function getPlayer(int $index): Player
    {
        return $this->players[$index];
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Return the losing player, or null when not decided yet.
     *
     * @return Player|null
     */
    public function getLoser(): ?Player
    {
        foreach ($this->players as $player) {
            if ($player->getPoints() >= 50) {
                return $player;
            }
        }

        return null;
    }

    /**
     * Gets the player that the starts the upcoming round.
     *
     * @return Player
     */
    public function getStartingPlayer(): Player
    {
        return $this->players[$this->startingPlayer];
    }
}
