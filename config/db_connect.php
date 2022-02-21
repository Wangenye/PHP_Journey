<?php

//connect to Database
$conn = mysqli_connect('localhost', 'neal', 'root', 'ninja_pizza');

if (!$conn) {
    echo "Connection Error :" * mysqli_connect_error();
}

?>