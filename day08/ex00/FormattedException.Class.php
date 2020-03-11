<?php
    class FormattedException extends Exception
    {
        public function __construct($message = "", $code = 0, Exception $previous = null) {
            parent::__construct($message, $code, $previous);
        }
        
        public function customMessage()
        {
            print("An exception occured! Error code ");
            print($this->getCode());
            print(": ");
            print($this->getMessage() . "\n");
        }
        
        public function doc()
        {
            print(file_get_contents('docs/FormattedException.doc.txt'));
        }
        
        
    }
?>