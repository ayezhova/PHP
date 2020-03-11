<?php
    require_once '../ex02/Vector.class.php';
    
    Class Matrix
    {
        public static $verbose = FALSE;
        const IDENTITY = 'IDENTITY';
        const SCALE = 'SCALE';
        const RX = 'RX';
        const RY = 'RY';
        const RZ = 'RZ';
        const TRANSLATION = 'TRANSLATION';
        const PROJECTION = 'PROJECTION';
        
        private $_vtcX;
        private $_vtcY;
        private $_vctZ;
        private $_vtxO;
        
        function __construct(array $kargs)
        {
            if (!isset($kargs['preset']))
                return FALSE;
            if ($kargs['preset'] === self::IDENTITY)
            {
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => 1.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 1.0, 'w' => 1.0))));
                $this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
            }
            if ($kargs['preset'] === self::TRANSLATION)
            {
                if (!isset($kargs['vtc']) || !($kargs['vtc'] instanceof Vector))
                    return FALSE;
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => 1.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 1.0, 'w' => 1.0))));
                $this->_vtxO = new Vertex(array('x' => $kargs['vtc']->getX(), 'y' => $kargs['vtc']->getY(), 'z' => $kargs['vtc']->getZ(), 'w' => 1.0));
            }
            if ($kargs['preset'] === self::SCALE)
            {
                if (!isset($kargs['scale']) || !(is_numeric($kargs['scale'])))
                    return FALSE;
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => 1.0 * $kargs['scale'], 'y' => 0.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1.0 * $kargs['scale'], 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 1.0 * $kargs['scale'], 'w' => 1.0))));
                $this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
            }
            if ($kargs['preset'] === self::RX)
            {
                if (!isset($kargs['angle']) || !(is_numeric($kargs['angle'])))
                    return FALSE;
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => 1.0 , 'y' => 0.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => cos($kargs['angle']), 'z' => sin($kargs['angle']), 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => -sin($kargs['angle']), 'z' => cos($kargs['angle']) , 'w' => 1.0))));
                $this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
            }
            if ($kargs['preset'] === self::RY)
            {
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => cos($kargs['angle']), 'y' => 0.0, 'z' => -sin($kargs['angle']), 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => sin($kargs['angle']), 'y' => 0.0, 'z' => cos($kargs['angle']), 'w' => 1.0))));
                $this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
            }
            if ($kargs['preset'] === self::RZ)
            {
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => cos($kargs['angle']), 'y' => sin($kargs['angle']), 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => -sin($kargs['angle']), 'y' => cos($kargs['angle']), 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 1.0, 'w' => 1.0))));
                $this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 1.0));
            }
            if ($kargs['preset'] === self::PROJECTION)
            {
                if (!isset($kargs['fov']) || !(is_numeric($kargs['fov'])) || !isset($kargs['ratio']) || !(is_numeric($kargs['ratio']) || !isset($kargs['near']) || !(is_numeric($kargs['near']) || !isset($kargs['far']) || !(is_numeric($kargs['far'])))))
                    return FALSE;
                $this->_vtcX = new Vector(array('dest' => new Vertex(array('x' => (1 / tan(0.5 * deg2rad($kargs['fov'])))/$kargs['ratio'], 'y' => 0.0, 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcY = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 1 / tan(0.5 * deg2rad($kargs['fov'])), 'z' => 0.0, 'w' => 1.0))));
                $this->_vtcZ = new Vector(array('dest' => new Vertex(array('x' => 0.0, 'y' => 0, 'z' => -1 * (-$kargs['near'] - $kargs['far']) / ($kargs['near'] - $kargs['far']), 'w' => 0.0))));
                $this->_vtxO = new Vertex(array('x' => 0.0, 'y' => 0, 'z' => (2 * $kargs['near'] * $kargs['far']) / ($kargs['near'] - $kargs['far']), 'w' => 0.0));
            }
            if ($kargs['preset'] === 'NEW')
            {
                $this->_vtcX = $kargs['X'];
                $this->_vtcY = $kargs['Y'];
                $this->_vtcZ = $kargs['Z'];
                $this->_vtxO = $kargs['O'];
            }
        }
        
        function __toString()
        {
            return sprintf("M | vtcX | vtcY | vtcZ | vtxO\n-----------------------------\nx | %.2f | %.2f | %.2f | %.2f\ny | %.2f | %.2f | %.2f | %.2f\nz | %.2f | %.2f | %.2f | %.2f\nw | %.2f | %.2f | %.2f | %.2f",
                            $this->_vtcX->getX(), $this->_vtcY->getX(), $this->_vtcZ->getX(), $this->_vtxO->getX(),
                            $this->_vtcX->getY(), $this->_vtcY->getY(), $this->_vtcZ->getY(), $this->_vtxO->getY(),
                            $this->_vtcX->getZ(), $this->_vtcY->getZ(), $this->_vtcZ->getZ(), $this->_vtxO->getZ(),
                            $this->_vtcX->getW(), $this->_vtcY->getW(), $this->_vtcZ->getW(), $this->_vtxO->getW());
        }
    }
?>