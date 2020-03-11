<?php
require_once '../ex01/Vertex.class.php';

Class Vector
{
	public static $verbose = FALSE;

	private $_x;
	private $_y;
	private $_z;
	private $_w;
	public $orig;

	function __construct(array $kargs)
	{
		if (!isset($kargs['dest']) || !($kargs['dest'] instanceof Vertex))
			return FALSE;
		if (isset($kargs['orig']) && ($kargs['orig'] instanceof Vertex))
      $this->orig = $kargs['orig'];
    else
      $this->orig = new Vertex(array( 'x' => 0.0, 'y' => 0.0, 'z' => 0.0));
		$this->_x = $kargs['dest']->getX() - $this->orig->getX();
		$this->_y = $kargs['dest']->getY() - $this->orig->getY();
		$this->_z = $kargs['dest']->getZ() - $this->orig->getZ();
    $this->_w = $kargs['dest']->getW() - $this->orig->getW();
    if (self::$verbose === TRUE)
    {
      printf("Vector( x: %.2f, y: %.2f, z:%.2f, w:%.2f ) constructed\n", $this->_x, $this->_y, $this->_z, $this->_w);
    }
	}
	
	function __toString()
	{
    return sprintf("Vector( x: %.2f, y: %.2f, z:%.2f, w:%.2f )", $this->_x, $this->_y, $this->_z, $this->_w);
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
	
	public static function doc()
	{
	  return file_get_contents('Vector.doc.txt');
	}
	
  public function magnitude()
  {
    return (float)sqrt(pow($this->_x , 2) + pow($this->_y , 2) + pow($this->_z, 2));
  }
  
  public function __destruct()
  {
    if (Self::$verbose === TRUE)
    {
      printf("Vector( x: %.2f, y: %.2f, z:%.2f, w:%.2f ) destructed\n", $this->_x, $this->_y, $this->_z, $this->_w);
    }
  }
  
  public function normalize()
  {
    $magn = $this->magnitude();
    $newVert = new Vertex( array( 'x' => ($this->_x)/$magn, 'y' => ($this->_y)/$magn, 'z' => ($this->_z)/$magn ) );
    return new Vector( array('dest' => $newVert ) );
  }
  
  public function add($rhs)
  {
    $newVert = new Vertex( array( 'x' => ($this->_x + $rhs->getX()), 'y' => ($this->_y + $rhs->getY()), 'z' => ($this->_z + $rhs->getZ()) ));
    return new Vector( array( 'dest' => $newVert ) );
  }
  
  public function sub($rhs)
  {
    $newVert = new Vertex( array( 'x' => ($this->_x - $rhs->getX()), 'y' => ($this->_y - $rhs->getY()), 'z' => ($this->_z - $rhs->getZ()) ));
     return new Vector( array( 'orig' => $this->orig, 'dest' => $newVert ) );
  }
  
  public function opposite()
  {
    return new Vector( array( 'orig' => $this->orig, 'dest' => new Vertex( array( 'x' => ($this->_x)*-1, 'y' => ($this->_y)*-1, 'z' => ($this->_z)*-1 ) )));
  }
  
  public function scalarProduct($k)
  {
    return new Vector( array( 'orig' => $this->orig, 'dest' => new Vertex( array( 'x' => ($this->_x)*$k, 'y' => ($this->_y)*$k, 'z' => ($this->_z)*$k ) )));
  }
  
  public function crossProduct($rhs)
  {
    $newVert = new Vertex( array( 'x' => ($this->_y * $rhs->getZ() - $this->_z * $rhs->getY()), 'y' => ($this->_z * $rhs->getX() - $this->_x * $rhs->getZ()), 'z' => ($this->_x * $rhs->getY() - $this->_y * $rhs->getX()) ));
    return new Vector( array( 'dest' => $newVert ) );
  }
  
  public function dotProduct($rhs)
  {
    return (float)($this->_x * $rhs->getX() + $this->_y * $rhs->getY() + $this->_z * $rhs->getZ());
  }

  public function cos(Vector $rhs)
  {
    $magA = $this->magnitude();
    $magB = $rhs->magnitude();
    $dot = $this->dotProduct($rhs);
    return $dot / ($magA * $magB);
  }
}

?>
