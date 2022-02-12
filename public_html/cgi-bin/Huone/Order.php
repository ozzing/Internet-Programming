<?php
header("Content-type: text/html");

$connect = new mysqli("localhost", "cse20191654", "cse20191654", "db_cse20191654") or die("DB Connection Failed");
$connect->query("set session character_set_connection=utf8;");
$connect->query("set session character_set_results=utf8;");
$connect->query("set session character_set_client=utf8;");

$id = $_POST["id"];
$people = $_POST["people"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$address = $_POST["address"];
$password = $_POST["password"];
$amount = $_POST["amount"];

if(empty($id) || empty($people) || empty($phone) || empty($email) || empty($address) || empty($password) || empty($amount) || $amount < 0) {
    http_response_code(400);
    echo "올바르지 않은 입력입니다.";
    die();
}

if(strlen($people) > 255 || strlen($phone) > 100 || strlen($email) > 255 || strlen($address) > 500 || strlen($password) > 20) {
    http_response_code(400);
    echo "올바르지 않은 입력입니다.";
    die();
}

$result = $connect->query("SELECT * FROM Huone_Data WHERE id = $id;");
$item_data = mysqli_fetch_assoc($result);
if(empty($item_data)) {
    http_response_code(400);
    echo "존재하지 않는 상품입니다.";
    die();
}

if($amount > $item_data["amount"]) {
    http_response_code(400);
    echo "재고가 없습니다.";
    die();
}

$password_encrypted = md5($password);

// Order
$result = $connect->query("UPDATE Huone_Data SET amount = amount - $amount WHERE id = $id;");

// Order List Insert
$result = $connect->query("INSERT INTO Huone_Order (`people`, `email`, `address`, `password`, `phone`, `amount`, `item_id`)
VALUES (\"$people\", \"$email\", \"$address\", \"$password_encrypted\", \"$phone\", $amount, $id);");

$connect->close();

$res = <<<HTML
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
</head>
<body>
<div class=home>
        <a href="/~cse20191596/Huone/Query.html">
            홈으로
        </a>
</div>
주문 완료!
</body>
HTML;
echo $res;

?>
