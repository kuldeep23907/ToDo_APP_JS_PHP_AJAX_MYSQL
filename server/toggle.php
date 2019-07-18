<?php 
include './config/connection.php'; 
include 'response.php';

$id=$_POST["id"];
$sql1="select * from `todo` where `id`='$id'";
$res=mysqli_query($conn,$sql1);
$row=mysqli_fetch_assoc($res);
if($row["iscompleted"]==1)
$sql="update `todo` set `iscompleted`=false  where `id`='$id'";
else if($row["iscompleted"]==0)
$sql="update `todo` set `iscompleted`=true  where `id`='$id'";

if(mysqli_query($conn,$sql) )
{
    
    $fff=successResponse($id);
    echo(json_encode($fff));
}
else
{
    $fff=errorResponse(mysqli_error($conn));
    echo(json_encode($fff));

} 



?>