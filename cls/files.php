<?php
class File {
    
    private $filePath = null;
    
    public  function __construct($filePath = "") {
         $this->filePath = $filePath;
    }
    
    public function SetFilePath($filePath) {
        $this->filePath = $filePath;
    }
    
    public function GetKey($key) {
        
    }

    public function PushToFile(array $data) {
        
    }
    
}