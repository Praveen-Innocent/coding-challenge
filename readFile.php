<?php

class readFile
{
    
    private $outputFile = "output.txt";
    private $errorMsg = "File does not exist!";
    private $patternMap = Array(    //Map of the object types and their patterns
					        "Numbers" => "/^[0-9]*$/", 
					        "Alphabets" => "/^[a-zA-Z]*$/", 
					        "Alphanumeric" => "/^[a-zA-Z0-9]*$/"
					      );
    
    public function readFromFile()
    {
        $file = $this->outputFile;
        if (file_exists($file)) {
            
            $fh = fopen($file, "r") or die("Unable to open file!");
            
            $contents = fread($fh, filesize($file));
            //echo $contents;
            fclose($fh);
            return $contents;
            
        } else {
            echo $this->errorMsg;
            exit;
        }
    }
    
    public function parseContents($contents) //Convert the file contents into an array of random objects
    {
        $arr = array_map('trim', explode(',', $contents));
        return $arr;
    }
    
    public function getObjType($obj) //Returns an array of random objects
    {
        
        $map = $this->patternMap;
        
        foreach ($map as $patternName => $pattern) {
            
            if (preg_match($pattern, $obj))
                return $patternName; //If pattern matches, return
            
        }
        
    }
    
    public function init()
    {
        $contents = self::readFromFile();
        $arr      = self::parseContents($contents);
        
        foreach ($arr as $key) {
            $type = self::getObjType($key); //Get each object type
            print $key . " - " . $type;
            print "\n";
        }
    }
    
}

$r = new readFile();
$r->init();

?>
