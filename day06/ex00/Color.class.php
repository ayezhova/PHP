<?php
    Class Color
    {
        public static $verbose = FALSE;
        public $red;
        public $green;
        public $blue;
        
        function __construct(array $kargs)
        {
            $num_args = count($kargs);
            if ($num_args == 1)
            {
                $this->blue = intval($kargs['rgb']) % 256;
                $this->green = (intval($kargs['rgb']) / 256) % 256;
                $this->red = (intval($kargs['rgb']) / (256 * 256)) % 256;
            }
            if ($num_args == 3)
            {
                $this->red = intval($kargs['red']);
                $this->green = intval($kargs['green']);
                $this->blue = intval($kargs['blue']);
            }
            if (self::$verbose)
                printf("Color: ( red: %3d, green: %3d, blue: %3d ) constructed.\n", $this->red, $this->green, $this->blue);
        }
        
        function __toString()
        {
            //return "Color( red: " . $this->red . ", green: " . $this->green . ", blue:  " . $this->blue . " )";
            return sprintf("Color: ( red: %3d, green: %3d, blue: %3d )", $this->red, $this->green, $this->blue);
        }
        
        public static function doc()
        {
            return file_get_contents('Color.doc.txt');
        }
        
        public function add($instant)
        {
            $new_red = min(255, $this->red + $instant->red);
            $new_green = min(255, $this->green + $instant->green);
            $new_blue = min(255, $this->blue + $instant->blue);
            return new Color(array('red' => $new_red, 'green' => $new_green, 'blue' => $new_blue));
        }
        
        public function sub($instant)
        {
            $new_red = max(0, $this->red - $instant->red);
            $new_green = max(0, $this->green - $instant->green);
            $new_blue = max(0, $this->blue - $instant->blue);
            return new Color(array('red' => $new_red, 'green' => $new_green, 'blue' => $new_blue));
        }
        
        public function mult($factor)
        {
            $new_red = min(255, $this->red * $factor);
            $new_green = min(255, $this->green * $factor);
            $new_blue = min(255, $this->blue * $factor);
            return new Color(array('red' => $new_red, 'green' => $new_green, 'blue' => $new_blue));
        }
        
        function __destruct()
        {
            if (self::$verbose)
                printf("Color: ( red: %3d, green: %3d, blue: %3d ) destructed.\n", $this->red, $this->green, $this->blue);
        }
    }
?>