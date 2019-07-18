<?php
include './config/connection.php'; 
header("Content-Type: application/json");

$filter=$_GET["filter"];
$all_captions=[];
$i=0;

if($filter=="all")
{
$sql="select * from  `todo` ";
$res=mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($res))
{
$todo = [
    [
        "caption" => $row["caption"],
        "isCompleted" => $row["iscompleted"],
        "index" => $row["id"],
    ],
];
$all_captions[$i]=$todo;
$i++;
}

echo (json_encode($all_captions));

}
else if ($filter=="completed")
{

$sql="select * from  `todo` where `iscompleted` =1 ";
$res=mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($res))
{
$todo = [
    [
        "caption" => $row["caption"],
        "isCompleted" => $row["iscompleted"],
        "index" => $row["id"],
    ],
];
$all_captions[$i]=$todo;
$i++;

}
echo (json_encode($all_captions));

}
else if ($filter=="uncompleted")
{
$sql="select * from  `todo` where `iscompleted` = 0 ";
$res=mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($res))
{
$todo = [
    [
        "caption" => $row["caption"],
        "isCompleted" => $row["iscompleted"],
        "index" => $row["id"],
    ],
];
$all_captions[$i]=$todo;
$i++;


}
echo (json_encode($all_captions));

}
else
{
mysqli_error($conn);

}


?>