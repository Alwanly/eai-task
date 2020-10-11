<?php 
     require 'vendor/autoload.php';

     $content = file_get_contents("http://localhost:3030/notes");
     $result = json_decode($content);
     print_r($result)
          
?>