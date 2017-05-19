<?php
define("IS_DEBUG_ONE_ITEM", false);
define("IS_DEBUG", true);

$vender_path = __DIR__ . "/../vendor/simplehtmldom_1_5/";
if (!is_dir($vender_path)) {
    die("die...");
}

require_once ($vender_path . "simple_html_dom.php");

if(IS_DEBUG_ONE_ITEM) {
    $number = 4;
    $data = getData($number);
    exit;
}

$number = 0;
$start = 1;
$end = 3000;
$data = [];

for ($number = $start; $number <= $end; $number++) {
    $data = getData($number);
}




function getData($number) {
    // Create DOM from URL or file
    unset($html, $url);
    $url = "https://new.tbj.com.tw/order.php?id=" . $number;
    $html = file_get_html($url);
    $content = $html->plaintext;

    if (empty($content)) {
        //echo "no data: " . $number . "\n";
    } else {
        // get title
        $dom = $html->find('div.top h1', 0);
        $h1List = explode("p>", $dom->innertext);

        $title = trim(array_pop($h1List));
        $category1 = trim($dom->find('a', 1)->innertext);
        $category2 = trim($dom->find('a', 2)->innertext);
        if (empty($category2)) {
            $category2 = $category1;
        }


        // get prize
        unset($dom);
        $dom = $html->find('input#ctol_h', 0);
        $prize = $dom->value;


        // for debug
        unset($data);
        $data = [$number, $category1, $category2, $title, $prize];
        if (IS_DEBUG) {
            echo(implode(" || " , $data) . "\n");
        }
    }
}
