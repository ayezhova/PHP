<?php
    require_once 'FormattedException.Class.php';
    require_once 'Get_Img.Trait.php';
    
    abstract Class Spaceship
    {
        public static $nbShips = 0;
        public static $verbose = FALSE;
        public $name = "NULL";
        protected $_img_url;
        protected $_bullet_size;
        private $_error = 0;
        public $position = array();
        
        use get_img;
        
        function __construct(array $kargs)
        {
            try {
                if (isset($kargs['name']) && isset($kargs['x']) && isset($kargs['y']) && isset($kargs['img_url']))
                {
                    $this->set_args($kargs);
                    self::$nbShips++;
                }
                else
                    throw new Exception("Missing base arguments", 1);
            } catch (Exception $exc) {
                print("An exception occured! Error code ");
                print($exc->getCode());
                print(": ");
                print($exc->getMessage() . "\n");
                $this->_error = 1;
            }
            if ($this->_error === 1)
            {
                echo "NO SHIP\n";
                return FALSE;
            }
            if (self::$verbose === TRUE)
                echo "Created Spaceship\n";
        }
        
        public static function get_num_ships()
        {
            if (self::$nbShips === 0 || self::$nbShips > 1)
                print("There are currently " . self::$nbShips . " ships.\n");
            else
                print("There is currently " . self::$nbShips . " ship.\n");
        }
        
        private function set_args(array $args_to_set)
        {
            $this->name = $args_to_set['name'];
            $this->position['x'] = $args_to_set['x'];
            $this->position['y'] = $args_to_set['y'];
            $this->_img_url = $args_to_set['img_url'];
        }
        
        abstract public function shoot();
        abstract public function __toString();
        
        
        public function doc()
        {
            print(file_get_contents('docs/Spaceship.doc.txt'));
        }
        
        static function spaceship_doc()
        {
            self::doc();
        }
    
        function ship_doc()
        {
            static::doc();
        }
        
        function __destruct()
        {
            if (parent::$verbose === TRUE)
                echo "Destroying Spaceship named " . $this->name . ".\n";
        }
        
        public static function __callstatic($f, $args)
        {
            print("Attempting to call static function ". $f ." with paramaters: ");
            print_r($args);
            print("This static function does not exist. Continued attempts to call this function may result in unstable behavior.\n");
        }
    }
?>