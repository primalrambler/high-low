<?php

// High-low game. Program picks a number between 1 and 100.
// Users guess, program tells them if it's higher or lower.


do {

	$max = 100;
	$min = 1;
	$guess = 0;
	$youWon = false;
	$playAgain = 'n';
	$numGuesses = 0;
	$inputOK = false;


	//verify the arguments are passed and numeric
	//
	$arg1 = (isset($argv[1])) && is_numeric($argv[1]) ? (int)$argv[1] : null;
	$arg2 = (isset($argv[2])) && is_numeric($argv[2]) ? (int)$argv[2] : null;
	$argArray = [$arg1,$arg2];


	// if parameters are ok figure out which
	// is max and which is min
	if (!is_null($arg1) && !is_null($arg2)) {
		$max = max($argArray);
		$min = min($argArray);

	// if at least one parameter was missed
	// then set the other one based on finding
	// the furthest value	
	} elseif (!(is_null($arg1) && is_null($arg2))){
		$arg1 = max($argArray);
		(abs($max - $arg1) > abs($min - $arg1)) ? $min = $arg1 : $max = $arg1;
		}

	//set gaming variables
	$rando = mt_rand($min,$max);
	$maxGuesses = intval(($max - $min)/5);


//welcome message
$message = <<<OPENING
Welcome to HI-LO. Guess the randomly chosen
number between $min and $max in less than $maxGuesses.

To quit type q or Q.

Good luck...

OPENING;

fwrite(STDOUT, $message);


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

	// process acceptable input
		} else {
			
			//guess is too high
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
