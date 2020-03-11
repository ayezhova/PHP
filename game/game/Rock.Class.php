<?php
    require_once 'IObstacle.Class.php';
    require_once 'Get_Img.Trait.php';
    
    final Class Rock implements IObstacle
    {
        private $_size;
        private $_damage;
        private $_img_url = 'resources/Rock-PNG-Transparent-Image.png';
        private $_error = 0;
        
        use get_img;
        
        public function __construct(array $kargs)
        {
            try
            {
                if (isset($kargs['size']) && isset($kargs['damage']))
                {
                    $this->_size = $kargs['size'];
                    $this->_damage = $kargs['damage'];
                }
                else
                {
                    throw new FormattedException("Missing arguments for creating rock", 1);
                }
            } catch (FormattedException $exc) {
                $exc->customMessage();
                $this->_error = 1;
            }
            if ($this->_error === 1)
            {
                echo "NO ROCK\n";
                return FALSE;
            }
        }
        
        public function get_size()
        {
            return $this->_size;
        }
        
        public function get_img()
        {
            return $this->_img_url;
        }
        
        public function get_damage()
        {
            return $this->_damage;
        }
        
        public function __toString()
        {
            return sprintf("Rock of size %d with damage of %d", $this->_size, $this->_damage);
        }
        
        public function doc()
        {
            print(file_get_contents('docs/IObstacle.doc.txt'));
            print(file_get_contents('docs/Rock.doc.txt'));
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