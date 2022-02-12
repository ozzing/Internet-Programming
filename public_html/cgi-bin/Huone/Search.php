<?php
header("Content-type: application/json");

$connect = new mysqli("localhost", "cse20191654", "cse20191654", "db_cse20191654") or die("DB Connection Failed");
$connect->query("set session character_set_connection=utf8;");
$connect->query("set session character_set_results=utf8;");
$connect->query("set session character_set_client=utf8;");

$name = $_POST["name"];

$result = $connect->query("SELECT * FROM Huone_Data WHERE name like \"%$name%\";");

$res = array();
while($row = mysqli_fetch_assoc($result)) {
    array_push($res, array(
        "id" => intval($row["id"]),
        "name" => $row["name"],
        "price" => intval($row["price"]),
        "img_src" => $row["img_src"],
    ));
}

$json_res = json_encode($res, JSON_UNESCAPED_UNICODE);

$connect->close();

echo $json_res;
?>
