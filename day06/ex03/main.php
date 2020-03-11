#!/usr/bin/php
<?php
    require_once 'Matrix.class.php';
    
    $P = new Matrix( array( 'preset' => Matrix::PROJECTION,
    'fov' => 60,
    'ratio' => 640/480,
    'near' => 1.0,
    'far' => -50.0 ) );
    print( $P . PHP_EOL . PHP_EOL );
?>