# Mikko-Test
A little CLI utility written in php. It's a demonstration of my programming
skills as part of an internship application.

The utility determines at what dates a fictional company should pay its sales
staff according to the following rules:

- Sales staff get a regular monthly fixed base salary and a monthly bonus.
- The base salaries are paid on the last day of the month unless that day is a Saturday or a Sunday
  (weekend)
- On the 15th of every month bonuses are paid for the previous month, unless that day is a weekend. In
  that case, they are paid the first Wednesday after the 15th

This info gets written to a .csv file the user specifies.

## Requirements
- PHP 5.6 or higher (>= 7.0 recommended)
- Composer installed

## Installation
1. Clone this repo
2. Run `$ composer update`

## How to use
1. Open project root
2. Run `$ php app/console.php dates:payday <filename>`

   Replace `<filename>` with a filename of your choosing. You don't have to put the
.csv extension after it.

## Frameworks & Libraries
- [Symfony/Console](https://symfony.com/doc/current/components/console/introduction.html)