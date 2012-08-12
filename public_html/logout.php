<?php 
setcookie("user", null, time()-100000000);
setcookie("token", null, time()-100000000);
header('Location: /darksouls/');
?>