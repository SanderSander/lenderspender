![Build badge](https://github.com/SanderSander/lenderspender/workflows/Checks/badge.svg)

# Heartbreak 

Simulation of a simplified heartbreak card game with four players.

## Requirements

- php >= 7.4

## Installation

```
composer install
```

## Usage

```
composer run simulation
```

## Testing

```
./vendor/bin/phpunit
```

## Known Issues

In the assessment we are required to have 32 cards, 
but we need only cards from 7 or higher which makes 28 cards.
There are multiple options to solve this, take cards from 6 or higher or 
by distributing multiple decks.

The simulation currently runs with 28 cards instead of 32 cards.
