

<?php
//取得指定位址的內容，并储存至 $text
$text=file_get_contents('http://www.jb51.net/');

//去除换行及空白字符（序列化內容才需使用）
//$text=str_replace(array("/r","/n","/t","/s"), '', $text);
$match=array();
$articleArr=array();

//取出 div 标签且 id 为 PostContent 的內容，并储存至二维数组 $match 中
preg_match('/<div[^>]*id="PostContent"[^>]*>(.*?) <\/div>/si',$text,$match);

//打印出match[0]

print_r($match);
