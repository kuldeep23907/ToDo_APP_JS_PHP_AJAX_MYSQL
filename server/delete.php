<?php
include './config/connection.php'; 
include 'response.php';
header("Content-Type: application/json");

$id=$_POST["id"];
$sql="delete from `todo` where `id`='$id' ";

if(mysqli_query($conn,$sql))
{
 $response_result=successResponse("success");
 echo(json_encode($response_result));
}
else
{
    echo mysqli_error($conn);

}

?>