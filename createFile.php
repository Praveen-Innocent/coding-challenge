<?php

class createFile {


	//Different Object Types
	private $alphabets ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	private $integers ="0123456789";
	private $alphaNumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	//Other Config
	private $delimiter = ",";
	private $objectMinLength = 5;
	private $objectMaxLength = 30;
	private $spacesMinLength = 0;
	private $spacesMaxLength = 15;
	private $sequenceLength = 10;
	private $outputFile = "output.txt"; 
	private $maxFileSize = 1000; //in bytes
	private $successMsg = "Success! Output written to file: "; 
	private $errorMsg = "Something went wrong!"; 



	private $objTypes; //An array to store object types

	public function __construct()
	{
		$this->objTypes = Array($this->alphabets,$this->integers,$this->alphaNumeric); //Populate array with different object types
	}

	public function init() {

		$contents = self::generateSequence($this->objTypes,$this->delimiter);
		$res = self::writeToFile($contents);
		if($res) echo $this->successMsg.$this->outputFile;
		else echo $this->errorMsg;
 	}

 	public function randomNumber($min, $max){  //Just a wrapper around default php rand(), can change to custom random number generation if required
			return rand($min,$max);
	}

	public function randomString($charSet, $length){
			$valid_chars= $charSet;
			$random_string = "";
			$num_valid_chars = strlen($valid_chars);
			for ($i = 0; $i < $length; $i++){
				$random_pick = mt_rand(1, $num_valid_chars);
				$random_char = $valid_chars[$random_pick-1];
				$random_string .= $random_char;
			}
			return $random_string;
	}

	public function generateSequence($items,$delimiter) {

		$sequence = "";

		for($i=0; $i <= $this->sequenceLength; $i++) {
			$string = " ";
			$randomLength = self::randomNumber($this->objectMinLength,$this->objectMaxLength); //Pick Random object length
			$randomObjectType = $items[array_rand($items)]; //Pick Random object type from array

			$randString = self::randomString( $randomObjectType, $randomLength ); //Generate random string of random object, with random length

			$spaceLengthBefore = self::randomNumber($this->spacesMinLength,$this->spacesMaxLength);
			$spaceLengthAfter = self::randomNumber($this->spacesMinLength,$this->spacesMaxLength);

			$spacesBefore = str_repeat(' ', $spaceLengthBefore); //Create Random spaces 
			$spacesAfter = str_repeat(' ', $spaceLengthAfter); //Create Random spaces 
			
			$string = $spacesBefore.$randString.$spacesAfter; //Add random spaces before and after

			$sequence.= $string.$delimiter; //Append delimiter at the end
		}
		$sequence = rtrim($sequence, ","); //Remove trailing comma
		return $sequence;
	}

	public function writeToFile($contents) {
		$file = $this->outputFile;
		if (file_exists($file) ) {
			if(filesize($file) > $this->maxFileSize) {
				echo "File size crossed maximum limit";  //Any action 
				exit;
			}

			$fh = fopen($file, 'a'); // if exists, append to it
		} else {
			$fh = fopen($file, 'w'); //else create new
		} 

		$res = fwrite($fh, $contents);
		fclose($fh); //closing file handler after writing
		return $res;
	}


}

$c = new createFile();
$c->init();

?>
