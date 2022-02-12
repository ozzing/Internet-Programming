<?php
header("Content-type: application/json");

$connect = new mysqli("localhost", "cse20191654", "cse20191654", "db_cse20191654") or die("DB Connection Failed");
$connect->query("set session character_set_connection=utf8;");
$connect->query("set session character_set_results=utf8;");
$connect->query("set session character_set_client=utf8;");

$id = $_POST["id"];

$result = $connect->query("SELECT * FROM Huone_Data WHERE id = $id;");

$res = NULL;
while($row = mysqli_fetch_assoc($result)) {
    $res = array(
        "id" => intval($row["id"]),
        "name" => $row["name"],
        "amount" => intval($row["amount"]),
        "price" => intval($row["price"]),
        "img_src" => $row["img_src"],
    );
}

if($res == NULL) {
    http_response_code(404);
    die();
}

$json_res = json_encode($res, JSON_UNESCAPED_UNICODE);

$connect->close();

echo $json_res;
?>
