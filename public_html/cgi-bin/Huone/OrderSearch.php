<?php
header("Content-type: application/json");

$connect = new mysqli("localhost", "cse20191654", "cse20191654", "db_cse20191654") or die("DB Connection Failed");
$connect->query("set session character_set_connection=utf8;");
$connect->query("set session character_set_results=utf8;");
$connect->query("set session character_set_client=utf8;");

$password = $_POST["password"];

if(empty($password)) {
    http_response_code(400);
    echo "올바르지 않은 입력입니다.";
    die();
}

if(strlen($password) > 20) {
    http_response_code(400);
    echo "올바르지 않은 입력입니다.";
    die();
}

$password_encrypted = md5($password);

$result = $connect->query("SELECT * FROM Huone_Order WHERE password = \"$password_encrypted\";");

$res = array();
while($row = mysqli_fetch_assoc($result)) {
    $id = intval($row["item_id"]);
    $name = $connect->query("SELECT name FROM Huone_Data WHERE id = \"$id\";");
    $name = mysqli_fetch_assoc($name);
    array_push($res, array(
        "item_id" => $id,
        "people" => $row["people"],
        "email" => $row["email"],
        "phone" => $row["phone"],
        "address" => $row["address"],
        "amount" => intval($row["amount"]),
        "order_date" => $row["order_date"],
        "name" => $name["name"],
  ));
}

$json_res = json_encode($res, JSON_UNESCAPED_UNICODE);

$connect->close();

echo $json_res;

?>
