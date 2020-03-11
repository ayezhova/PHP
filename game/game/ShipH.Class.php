<?php
    require_once 'Spaceship.Class.php';
    
    final class ShipH extends Spaceship
    {
        private $_error = 0;
        function __construct(array $kargs)
        {
            if (parent::__construct($kargs) === FALSE)
            {
                echo "NO SHIP H\n";
                return FALSE;
            }
            try {
                if (!$this->set_bullet_size($kargs))
                    throw new FormattedException("Missing ShipH Specific Arguments", 1);
            } catch (FormattedException $exc) {
                $exc->customMessage();
                $this->_error = 1;
            }
            if ($this->_error === 1)
            {
                echo "NO SHIP\n";
                return FALSE;
            }
            if (parent::$verbose === TRUE)
                echo "Created ShipH named " . $this->name . ".\n";
        }
        
        private function set_bullet_size(array $kargs)
        {
            if (isset($kargs['bullet']))
            {
                $this->_bullet_size = $kargs['bullet'];
                return TRUE;
            }
            else
                return FALSE;
        }
        
        public function shoot()
        {
            console.log("Bang\n");
        }
        
        public function __toString()
        {
            return "Ship shooting horizontally created, shooting bullet size " . $this->_bullet_size;
        }
        
        public function get_bullet_size()
        {
            return $this->_bullet_size;
        }
        
        public function doc()
        {
            print(file_get_contents('docs/ShipH.doc.txt'));
        }
        
        function __destruct()
        {
            if (parent::$verbose === TRUE)
                echo "Destroying ShipH named " . $this->name . ".\n";
        }
        
        public function __get($att)
        {
            print("Attempting to access variable " . $att .". This varible is either private or does not exist.\n");
        }
        
        public function __set($att, $value)
        {
            print("Attempting to set " . $att . " to " . $value . ". This varible is either private or does not exist.\n");
        }

        public function __call($name, $arguments)
        {
            print("Attempting to call " . $name . ". This function is either private or does not exist.\n");
        }
    }
?>