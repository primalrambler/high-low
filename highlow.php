<?php

// High-low game. Program picks a number between 1 and 100.
// Users guess, program tells them if it's higher or lower.


do {

	$guess = 0;
	$youWon = false;
	$playAgain = 'n';
	$numGuesses = 0;
	$inputOK = false;

$message = <<<OPENING
Welcome to HI-LO. To play, start by picking the high 
and low numbers of your guessing range.
Then we'll generate a random number for you to guess.
See if you can guess it with less than the max number
of guesses we'll calculate for you.

To quit type q or Q.	
Good luck...

OPENING;

	fwrite(STDOUT, $message);

	//get max number
	do {
		fwrite(STDOUT,"Key in the highest number to guess: ");
		$max = fgets(STDIN);
		if ($max == PHP_EOL){
			$max = 100;
			fwrite(STDOUT,"Your max will be 100".PHP_EOL);
		} elseif (!is_numeric(trim($max))) {
			fwrite(STDOUT,"You need to enter a number for a maximum".PHP_EOL);
		} else
			$max = trim($max);
			$inputOK = true;
	} while ($inputOK == false);

	//resets check input boolean
	$inputOK = false;

	//get min number

	do {
		fwrite(STDOUT,"Key in the highest number to guess: ");
		$min = fgets(STDIN);
		if ($min == PHP_EOL){
			$min = 1;
			fwrite(STDOUT,"Your min will be 1".PHP_EOL);
		} elseif (!is_numeric(trim($min))) {
			fwrite(STDOUT,"You need to enter a number for the minimum".PHP_EOL);
		} else
			$min = trim($min);
			$inputOK = true;
	} while ($inputOK == false);

	//set gaming variables
	$rando = mt_rand($min,$max);
	$maxGuesses = intval(($max - $min)/5);
	fwrite(STDOUT,"You will have $maxGuesses guesses to guess the number.".PHP_EOL);

	//play the game
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
			$guessesLeft = $maxGuesses - $numGuesses;
			fwrite(STDOUT,"You now have $guessesLeft guesses left.".PHP_EOL);
			continue;

		//guess is out of bounds	
		} elseif ($guess < $min || $guess > $max) {
				fwrite(STDOUT,"Enter a number between $min and $max inclusive".PHP_EOL);
				$numGuesses += 1;
				$guessesLeft = $maxGuesses - $numGuesses;
				fwrite(STDOUT,"You now have $guessesLeft guesses left.".PHP_EOL);
				continue;

		// process the acceptable input
		
		//guess is too high
		} else {
			if ($guess > $rando){
				fwrite(STDOUT,"The guess is too high".PHP_EOL);
				$numGuesses += 1;
				$guessesLeft = $maxGuesses - $numGuesses;
				fwrite(STDOUT,"You now have $guessesLeft guesses left.".PHP_EOL);

			//guess to low
			} elseif ($guess < $rando){ 
				fwrite(STDOUT,"The guess is too low".PHP_EOL);
				$numGuesses += 1;
				$guessesLeft = $maxGuesses - $numGuesses;
				fwrite(STDOUT,"You now have $guessesLeft guesses left.".PHP_EOL);
			
			//guess is correct
			} else {
				$youWon = true;
				$numGuesses += 1;
				fwrite(STDOUT,"Congratulations you guessed it.".PHP_EOL);
				fwrite(STDOUT,"The number was in fact $rando".PHP_EOL);
				fwrite(STDOUT,"It took you $numGuesses guesses to figure that out.".PHP_EOL);
				$guessesLeft = $maxGuesses - $numGuesses;
				fwrite(STDOUT,"You had $guessesLeft guesses left.").PHP_EOL;
				
				//find out if user wants to play again
				fwrite(STDOUT,"Do you want to play again (y/n)? ");
				$playAgain = trim(fgets(STDIN));
					if (strtolower($playAgain[0]) == "y"){
						fwrite(STDOUT,"Alright let's start over!".PHP_EOL);
						}
			}
		}

	} while ($youWon == false && $numGuesses < $maxGuesses);

} while (strtolower($playAgain[0]) != 'n');

fwrite(STDOUT,"GAME OVER");
