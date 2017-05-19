<?php
mb_internal_encoding("UTF-8");

$data = file_get_contents('data.txt');

$dataList = explode("\n", $data);
$jsDataList = array();
$url = "https://new.tbj.com.tw/order.php?id=";
foreach ($dataList AS $key => $dataRow) {
    $dataValue = explode(" || ", $dataRow);
    $category = $dataValue[2];
    $item = do_translit($dataValue[3]);
    if ('牛肉市集' == $category) {
        $itemNewStr = mb_substr($item, 0, 22) . "..";
    } else {
        $itemNewStr = ".." . mb_substr($item, -14);
    }

    $price = $dataValue[4];
    $itemUrl = $url . $dataValue[0];
    $s = "$" . $price . " 元 " . $itemNewStr;
    echo $txt = sprintf("<li data-filtertext=\"%s\"><a href=\"%s\">%s</a></li>", $itemNewStr, $itemUrl,  $s) . "\n";
}

function do_translit($st) { 
    $replacement = array( 
        "【台北濱江】" => "",
        "濱江" => "",
        "嚴選" => "",
        "-最頂級-" => "",
        "頂級" => "",
        "精心獨門醬汁手法醃製，精選大廚極品美味~" => "",
            ); 

    foreach($replacement as $i=>$u) { 
        $st = mb_eregi_replace($i,$u,$st); 
    } 
    return $st; 
} 
