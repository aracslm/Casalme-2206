<?php
$Connections = mysqli_connect("localhost","root","", "ara_db");
    if(mysqli_connect_errno()){
        echo"Failed to connect in mysql" . mysqli_connect_error();
    }else{
        echo"";
    }

?>