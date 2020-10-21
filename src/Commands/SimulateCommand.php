<?php

declare(strict_types=1);

namespace Acme\Commands;

use Acme\Deck\DeckFactory;
use Acme\Game;
use Acme\Player;
use Acme\RandomGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SimulateCommand extends Command
{
    protected static $defaultName = 'simulate';

    protected int $rounds = 0;

    protected function configure(): void
    {
        $this
            ->setDescription('Simulate card game')
            ->setHelp('This command runs the heartbreak game simulation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $game = new Game([
                new Player("John"),
                new Player("Jane"),
                new Player("Jan"),
                new Player("Otto"),
            ],
            new DeckFactory(true),
            new RandomGenerator()
        );

        $this->begin($game, $output);

        while(!$game->finished()) {
            $output->writeln('');
            $this->play($game, $output);
        }

        $output->writeln('');
        $this->writeScores($game, $output);

        return Command::SUCCESS;
    }

    protected function writeScores(Game $game, OutputInterface $output):void {
        $output->writeln(sprintf('%s loses the game!', $game->getLoser()));
        $output->writeln('Points:');
        foreach($game->getPlayers() as $player) {
            $output->writeln(sprintf(
                "%s:\t%d",
                $player,
                $player->getPoints()
            ));
        }
    }

    protected function begin(Game $game, OutputInterface $output): void {
        $output->writeln(sprintf(
            'Starting a game with %s, %s, %s, %s',
            $game->getPlayer(0),
            $game->getPlayer(1),
            $game->getPlayer(2),
            $game->getPlayer(3),
        ));

        $game->distributeCards();

        $this->writeDealtCards($game->getPlayer(0), $output);
        $this->writeDealtCards($game->getPlayer(1), $output);
        $this->writeDealtCards($game->getPlayer(2), $output);
        $this->writeDealtCards($game->getPlayer(3), $output);
    }

    protected function play(Game $game, OutputInterface $output):void {
        $output->writeln(sprintf(
            'Round %d: %s starts the game',
            ++$this->rounds,
            $game->getStartingPlayer(),
        ));

        if(!$game->getStartingPlayer()->hasCards()) {
            $output->writeln('Players ran out of cards. Reshuffle');
            $game->distributeCards();
            $this->writeDealtCards($game->getPlayer(0), $output);
            $this->writeDealtCards($game->getPlayer(1), $output);
            $this->writeDealtCards($game->getPlayer(2), $output);
            $this->writeDealtCards($game->getPlayer(3), $output);
        }

        // Play the game
        $table = $game->play();

        // Output the played cards
        foreach($table->getCards() as $played) {
            $output->writeln(sprintf(
                "%s plays:\t%s",
                $played[0],
                $played[1],
            ));
        }

        // Output loser information
        $losingPlayer = $table->getLosingPlayer();
        $output->writeln(sprintf(
            '%s played %s, the highest matching card of this match and got %d point added to his total
score. %s’s total score is %d points.',
            $losingPlayer,
            $table->getPlayedCard($losingPlayer),
            $table->getPoints(),
            $losingPlayer,
            $losingPlayer->getPoints()
        ));
    }

    private function writeDealtCards(Player $player, OutputInterface $output):void {
        // TODO we are missing one card, also this can be more generic
        $output->writeln(sprintf(
            "%s has been dealt:\t%s %s %s %s %s %s %s",
            $player,
            $player->getCard(0),
            $player->getCard(1),
            $player->getCard(2),
            $player->getCard(3),
            $player->getCard(4),
            $player->getCard(5),
            $player->getCard(6),
            //$player->getCard(7),
        ));
    }
}
