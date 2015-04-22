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
	private $spacesMinLength = 5;
	private $spacesMaxLength = 30;
	private $sequenceLength = 10;
	private $outputFile = "output.txt"; 
	private $maxFileSize = 1024; //in mb
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

			$randomLength = rand($this->objectMinLength,$this->objectMaxLength); //Pick Random object length
			$randomObjectType = $items[array_rand($items)]; //Pick Random object type from array

			$r = self::randomString( $randomObjectType, $randomLength ); //Generate random string of random object, with random length
			$s = str_pad($r,10);

			$sequence.= $s.$delimiter;
		}
		$sequence = rtrim($sequence, ","); //Remove trailing comma
		return $sequence;
	}

	public function writeToFile($contents) {
		$file = $this->outputFile;
		if (file_exists($file) ) {
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
