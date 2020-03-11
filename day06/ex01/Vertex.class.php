<?php
    require_once '../ex00/Color.class.php';
    
    Class Vertex
    {
        public static $verbose = FALSE;
        
        private $_x;
        private $_y;
        private $_z;
        private $_w;
        private $_color;
        
        function __construct(array $kargs)
        {
            if (!isset($kargs['x']) || is_numeric($kargs['x']) === FALSE || !isset($kargs['y']) || is_numeric($kargs['y']) === FALSE || !isset($kargs['z']) || is_numeric($kargs['z']) === FALSE)
                return FALSE;
            $this->_x = $kargs['x'];
            $this->_y = $kargs['y'];
            $this->_z = $kargs['z'];
            if (isset($kargs['w']) && is_numeric($kargs['w']) !== FALSE)
                $this->_w = $kargs['w'];
            else
                $this->_w = 1.0;
            if (isset($kargs['color']) && ($kargs['color'] instanceof Color))
                $this->_color = $kargs['color'];
            else
                $this->_color = new Color(array('rgb' => 0xFFFFFF));
            if (self::$verbose)
                printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, Color( red: %3d, green: %3d, blue: %3d ) ) constructed\n", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
        }
        
        function __toString()
        {
            if (Self::$verbose === TRUE)
            {
              return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, Color( red: %3d, green: %3d, blue: %3d ) )", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
            }
            else
              return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f )", $this->_x, $this->_y, $this->_z, $this->_w);
        }
        
        public static function doc()
        {
            return file_get_contents('Vertex.doc.txt');
        }
        
        public function getX()
        {
          return $this->_x;
        }
        
        public function getY()
        {
          return $this->_y;
        }
        
        public function getZ()
        {
          return $this->_z;
        }
        
        public function getW()
        {
          return $this->_w;
        }
        
        public function getColor()
        {
          return $this->_color;
        }
        
        public function setX($arg)
        {
          if (is_numeric($arg))
            $this->_x = $arg;
        }
        
        public function setY($arg)
        {
          if (is_numeric($arg))
            $this->_y = $arg;
        }
        
        public function setZ($arg)
        {
          if (is_numeric($arg))
            $this->_z = $arg;
        }
        
        public function setW($arg)
        {
          if (is_numeric($arg))
            $this->_w = $arg;
        }
        
        public function setColor($arg)
        {
          if ($arg instanceof Color)
            $this->_color = $arg;
        }
        
        public function __destruct()
        {
            if (self::$verbose)
                printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, Color( red: %3d, green: %3d, blue: %3d ) ) destructed\n", $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);

        }
    }
?>