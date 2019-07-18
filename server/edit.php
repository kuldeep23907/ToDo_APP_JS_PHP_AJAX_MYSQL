<?php 
include './config/connection.php'; 
include 'response.php';
header("Content-Type: application/json");

$id=$_POST["id"];
$turn=$_GET["turn"];

if($turn==1)
$caption=$_POST["caption"];

$sql1="select * from `todo` where `id`='$id'";
$res=mysqli_query($conn,$sql1);
$row=mysqli_fetch_assoc($res);

if($turn==0)
{
  if($row["iscompleted"]==1)
$sql="update `todo` set `iscompleted`=false  where `id`='$id'";
else if($row["iscompleted"]==0)
$sql="update `todo` set `iscompleted`=true  where `id`='$id'";
  
}

else if($turn==1)
{
if($row["iscompleted"]==1)
$sql="update `todo` set  `caption` = '$caption' where `id`='$id'";
else if($row["iscompleted"]==0)
$sql="update `todo` set  `caption` = '$caption' where `id`='$id'";

}

if(mysqli_query($conn,$sql) )
{
    
    $response_result=successResponse("success");
    echo(json_encode($response_result));
}
else
{
    $response_result=errorResponse(mysqli_error($conn));
    echo(json_encode($response_result));

} 

?>