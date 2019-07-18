<?php

//connect to mysql here and use the connection everywhere else

$conn=mysqli_connect("localhost","root","goldtree9","training");
if(!$conn)
echo mysqli_error($conn);

?>