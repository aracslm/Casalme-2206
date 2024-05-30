<?php

$con=new mysqli('localhost','root','','ara_db');
if($con){
    echo("");
}else{
    die(mysqli_error($con));
}


?>