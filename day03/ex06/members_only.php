<?php
  if ($_SERVER["PHP_AUTH_USER"] !== "zaz" || $_SERVER["PHP_AUTH_PW"] !== "Ilovemylittleponey")
  {
    header('HTTP/1.0 401 Unauthorized');
    header("WWW-Authenticate: Basic realm=''Member area''");
  ?>
<html><body>That area is accessible for members only</body></html>
<?php
  }
  else {
?>
<html><body>
Hello Zaz<br />
<img src='data:image/png;base64,<?php echo base64_encode(file_get_contents('../img/42.png')); ?>'>
</body></html>
<?php
}
?>
