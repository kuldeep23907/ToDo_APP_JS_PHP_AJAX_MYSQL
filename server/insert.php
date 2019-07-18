<?php

header("Content-Type: application/json");

include './config/connection.php'; 
include 'response.php';
$caption=$_POST["caption"];
$iscompleted="0";


$success = [
    [
        "caption" => $caption,
        "isCompleted" => $iscompleted,
        "error_type" => mysqli_error($conn),
    
    ]
];

if(!is_string($caption)  || preg_match("/[a-zA-Z0-9]+/",$caption)==0)
{

$success = [
    [
        "caption" => $caption,
        "isCompleted" => $iscompleted,
        "error_type" => "Enter a string only",
    
    ]
];
    $response_result=errorResponse($success);
    echo(json_encode($response_result));

}
else if(($iscompleted == "0" || $iscompleted == "1")&& ($caption != NULL || $caption != ""))
{

$sql="Insert into `todo` (`caption`,`iscompleted` ) values ('$caption','$iscompleted')";

if(mysqli_query($conn,$sql) )
{
    $sql1="select * from `todo`";
    $res=mysqli_query($conn,$sql1);
    $i=0;
    $prev=[];
    while($roww=mysqli_fetch_assoc($res))
    {
        $prev=$roww;

    } 
    $success1 = [
    [
        "caption" => $caption,
        "isCompleted" => $iscompleted,
        "index" => $prev["id"]
    ]

      ] ;
    $response_result=successResponse($success1);

    echo(json_encode($response_result));

}
else
{
    $success = [
    [
        "caption" => $caption,
        "isCompleted" => $iscompleted,
        "error_type" => mysqli_error($conn),
    
    ]
];
    $response_result=errorResponse($success);
    echo(json_encode($response_result));

} 
}
else
{
    $success = [
    [
        "caption" => $caption,
        "isCompleted" => $iscompleted,
        "error_type" => "correctly enter the caption and iscompleted value",
    
    ]
];
    $response_result=errorResponse($success);
    echo(json_encode($response_result));
}

?>