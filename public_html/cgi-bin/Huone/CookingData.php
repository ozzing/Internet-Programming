<?php   
  header('Content-Type: text/html; charset=utf-8');

function startsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    return substr( $haystack, 0, $length ) === $needle;
}

function price_str_to_num($price) {
  $price = preg_replace("/&#8361;/s", "", $price);
  $price = preg_replace("/[^0-9]*/s", "", $price); 

  return intval($price);
}

function get_img_real_path($img_src, $host) {
  if(startsWith($img_src, "http") || startsWith($img_src, "https")) {
    return $img_src;
  }
  else if(startsWith($img_src, "//")) {
    return "http:" . $img_src;
  }
  else {
    return "http://$host" . $img_src;
  }
}

$connect = new mysqli('localhost', 'cse20191654', 'cse20191654', 'db_cse20191654') or die('DB Connection Failed');

$connect->query("set session character_set_connection=utf8;");
$connect->query("set session character_set_results=utf8;");
$connect->query("set session character_set_client=utf8;");

$result = $connect->query("SELECT * FROM Huone_Data_raw;");

while($row = mysqli_fetch_assoc($result)) {
  $host = $row["host"];
  $img = $row["img_src"];
  $name = $row["name"];
  $price = $row["price"];

  $real_img_src = get_img_real_path($img, $host);
  $real_name = trim($name);
  $real_price = price_str_to_num($price);

  $duplicate = $connect->query("SELECT * FROM Huone_Data WHERE name=\"$name\";");
  if(mysqli_fetch_assoc($duplicate)) {
    // 이미 등록된 상품이면
    $connect->query("UPDATE Huone_Data SET amount=amount+30 WHERE name=\"$name\";");
  }
  else {
    $connect->query("INSERT INTO Huone_Data (`name`, `price`, `amount`, `img_src`) VALUES (\"$real_name\", $real_price, 30, \"$real_img_src\");");
  }
}

$connect->close();
?>
