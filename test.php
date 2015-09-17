<?php 
<<<<<<< HEAD
function getRealIP() {
=======
function getIP() {
>>>>>>> origin/master
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
       
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
   
    return $_SERVER['REMOTE_ADDR'];
}
<<<<<<< HEAD
echo 'IP = '.getRealIP();
=======
echo 'IP = '.getIP()."<br>";
echo $_ENV["COMPUTERNAME"]  
>>>>>>> origin/master
 ?>