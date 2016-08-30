<?php

// High-low game. Program picks a number between 1 and 100.
// Users guess, program tells them if it's higher or lower.

$guess = 0;
$youWon = false;
$playAgain = 'n';
$numGuesses = 0;
$max = 100;
$min = 1;
$rando = mt_rand($min,$max);
$maxGuesses = intval(($max - $min)/4);


fwrite(STDOUT,"Welcome to HI-LO. The computer picks a number between 1 and 100 and you need to guess it to win.".PHP_EOL);
fwrite(STDOUT,"The computer will tell you if the number is higher or lower. You can then make another guess.".PHP_EOL);
fwrite(STDOUT,"To quit type Q".PHP_EOL);
fwrite(STDOUT,"Good luck!".PHP_EOL);


do {
	fwrite(STDOUT,'Your guess: ');
	$guess = trim(fgets(STDIN));

	//check for bad input...

	//check for exiting game
	if (strtolower($guess[0]) == "q"){
		exit(0);

	//make sure the guess is a number	
	} elseif (!is_numeric($guess)) {
		fwrite(STDOUT,"You need to enter a number for a guess".PHP_EOL);
		$numGuesses += 1;
		continue;

	//guess is out of bounds	
	} elseif ($guess < 1 || $guess > 100) {
			fwrite(STDOUT,"Enter a number between 1 and 100 inclusive".PHP_EOL);
			$numGuesses += 1;
			continue;

	// process the acceptable input
	} else {
		if ($guess > $rando){
			fwrite(STDOUT,"The guess is too high".PHP_EOL);
			$numGuesses += 1;
		} elseif ($guess < $rando){
			fwrite(STDOUT,"The guess is too low".PHP_EOL);
			$numGuesses += 1;
		} else {
			$youWon = true;
			$numGuesses += 1;
			fwrite(STDOUT,"Congratulations you guessed it.".PHP_EOL);
			fwrite(STDOUT,"The number was in fact $rando".PHP_EOL);
			fwrite(STDOUT,"It took you $numGuesses guesses to figure that out.".PHP_EOL);
			fwrite(STDOUT,"Do you want to play again (y/n)? ");
			$playAgain = trim(fgets(STDIN));
				if (strtolower($playAgain[0]) == "y"){
					//reset global variables
					$rando = mt_rand(1,100);
					$youWon = false;
					$numGuesses = 0;
					fwrite(STDOUT,"Alright let's start over! We've got a new number to guess".PHP_EOL);
					}
		}
	}

} while ($youWon == false);