<?php
  header('Content-Type: text/html; charset=utf-8');

include('/sogang/under/cse20191654/public_html/cgi-bin/Huone/simple_html_dom.php');
$connect = new mysqli('localhost', 'cse20191654', 'cse20191654', 'db_cse20191654') or die('DB Connection Failed');

$result = $connect->query("DELETE FROM Huone_Data_raw;");
$connect->query("set session character_set_connection=utf8;");
$connect->query("set session character_set_results=utf8;");
$connect->query("set session character_set_client=utf8;");

# SHOP 1

$urls = array(
    'http://bcoe.co.kr/category/bracelet/53/',
    'http://bcoe.co.kr/category/cap/55/',
    'http://bcoe.co.kr/category/fashion/56/',
    'http://bcoe.co.kr/category/phone-acc/81/',
);

foreach($urls as $url) {
    $html = file_get_html($url);

    foreach($html->find('div[class=item_list_box]') as $item_elem) {
        $img = $item_elem->find('.thumb_Img', 0)->src;
        $name = $item_elem->find('.name', 0)->plaintext;
        $price = $item_elem->find('.pri', 0)->plaintext;

        // DB insert
        $connect->query("INSERT INTO Huone_Data_raw (`host`, `img_src`, `name`, `price`) VALUES (\"bcoe.co.kr\", \"$img\", \"$name\", \"$price\");");
    }

    sleep(3);
}

# SHOP 2

$urls = array(
    'https://withice.or.kr/83',
    'https://withice.or.kr/84',
    'https://withice.or.kr/82',
    'https://withice.or.kr/88',
);

foreach($urls as $url) {
    $html = file_get_html($url);

    foreach($html->find('div[class=shop-item]') as $item_elem) {
        $img = $item_elem->find('.shop-item-thumb', 0)->find('img', 0)->src;
        $name = $item_elem->find('.item-pay', 0)->find('h2', 0)->plaintext;
        $price = $item_elem->find('.pay', 0)->plaintext;

        // DB insert
        $connect->query("INSERT INTO Huone_Data_raw (`host`, `img_src`, `name`, `price`) VALUES (\"withice.co.kr\", \"$img\", \"$name\", \"$price\");");
    }

    sleep(3);
}

# SHOP 3

$urls = array(
    'http://joinheeum.com/product/list.html?cate_no=29',
    'http://joinheeum.com/product/list.html?cate_no=30',
    'http://joinheeum.com/product/list.html?cate_no=31',
    'http://joinheeum.com/product/list.html?cate_no=33',
    'http://joinheeum.com/product/list.html?cate_no=53',
    'http://joinheeum.com/product/list.html?cate_no=41',
);

foreach($urls as $url) {
    $html = file_get_html($url);

    foreach($html->find('div[class=prdList1]') as $item_elem) {
        $img = $item_elem->find('img', 0)->src;
        $name = $item_elem->find('.name', 0)->plaintext;
        $price = $item_elem->find('.price', 0)->plaintext;

        // DB Insert
        $connect->query("INSERT INTO Huone_Data_raw (`host`, `img_src`, `name`, `price`) VALUES (\"joinheeum.com\", \"$img\", \"$name\", \"$price\");");
    }

    sleep(3);
}


# SHOP 4

$urls = array(
    'http://befriendmarket.com/m/product_list.html?xcode=013&type=N&mcode=001',
    'http://befriendmarket.com/m/product_list.html?xcode=013&type=N&mcode=002',
    'http://befriendmarket.com/m/product_list.html?xcode=013&type=N&mcode=003',
    'http://befriendmarket.com/m/product_list.html?xcode=013&type=N&mcode=004',
    'http://befriendmarket.com/m/product_list.html?xcode=013&type=N&mcode=005',
    'http://befriendmarket.com/m/product_list.html?xcode=013&type=N&mcode=006',
);

foreach($urls as $url) {
    $html = file_get_html($url);
    
    foreach($html->find('li[class=prod_box]') as $item_elem) {
        $img = $item_elem->find('.prod_thum', 0)->find('img', 0)->src;
        $name = $item_elem->find('.prod_info', 0)->find('.prod_name', 0)->plaintext;
        $price = $item_elem->find('.prod_price', 0)->plaintext;

        // DB Insert
        $connect->query("INSERT INTO Huone_Data_raw (`host`, `img_src`, `name`, `price`) VALUES (\"befriendmarket.com\", \"$img\", \"$name\", \"$price\");");
    }

    sleep(3);
}

# SHOP 5

$urls = array(
    'http://meridiani.co.kr/product/list_thumb.html?cate_no=23&page=1',
    'http://meridiani.co.kr/product/list_thumb.html?cate_no=23&page=2',
);

foreach($urls as $url) {
    $html = file_get_html($url);

    foreach($html->find('div[class=item_list_box]') as $item_elem) {
        $img = $item_elem->find('.thumb_Img', 0)->src;
        $name = $item_elem->find('.name', 0)->plaintext;
        $price = $item_elem->find('.pri', 0)->plaintext;

        // DB Insert
        $connect->query("INSERT INTO Huone_Data_raw (`host`, `img_src`, `name`, `price`) VALUES (\"meridiani.co.kr\", \"$img\", \"$name\", \"$price\");");
    }
}

# SHOP 6

$urls = array(
    'http://new-kit.com/product/list.html?cate_no=43',
);

foreach($urls as $url) {
    $html = file_get_html($url);

    foreach($html->find('li[class=item]') as $item_elem) {
        $img = $item_elem->find('img', 0)->src;
        $name = $item_elem->find('.name', 0)->plaintext;
        $price = $item_elem->find('.xans-product', 0)->find('span', 1)->plaintext;
    
        // DB Insert
        $connect->query("INSERT INTO Huone_Data_raw (`host`, `img_src`, `name`, `price`) VALUES (\"new-kit.com\", \"$img\", \"$name\", \"$price\");");
    }
}

$connect->close();

include('/sogang/under/cse20191654/public_html/cgi-bin/Huone/CookingData.php');

?>
