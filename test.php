<?php
header("Content-type:text/html;charset=utf-8");
// It may take a whils to crawl a site ...
set_time_limit(10000);

include("libs/PHPCrawler.class.php");
class MyCrawler extends PHPCrawler
{
    function handleDocumentInfo($DocInfo)
    {
        // Just detect linebreak for output ("\n" in CLI-mode, otherwise "<br>").
        if (PHP_SAPI == "cli") $lb = "\n";
        else $lb = "<br />";

        $url = $DocInfo->url;
//        $pat = "/http:\/\/www\.kugou\.com\/yy\/special\/single\/\d+\.html/";
        $pat = "http://www.wvmp360.com/lytc.asp?uid=&brand=";
//        if(preg_match($pat,$url) > 0){
//            $this->parseSonglist($DocInfo);
        $this->ParseTripsArticle($DocInfo);
//        }
//        flush();
    }

    public function parseSonglist($DocInfo)
    {
        $content = $DocInfo->content;
        $songlistArr = array();
        $songlistArr['raw_url'] = $DocInfo->url;
        //解析歌曲介绍
        $matches = array();
        $pat = "/<span>名称：<\/span>([^(<br)]+)<br/";
        $ret = preg_match($pat, $content, $matches);
        if ($ret > 0) {
            $songlistArr['title'] = $matches[1];
        } else {
            $songlistArr['title'] = '';
        }
        //解析歌曲
        $pat = "/<a title=\"([^\"]+)\" hidefocus=\"/";
        $matches = array();
        preg_match_all($pat, $content, $matches);
        $songlistArr['songs'] = array();
        for ($i = 0; $i < count($matches[0]); $i++) {
            $song_title = $matches[1][$i];
            array_push($songlistArr['songs'], array('title' => $song_title));
        }
        echo "<pre>";
        print_r($songlistArr);
        echo "</pre>";
    }

    public function ParseTripsArticle($DocInfo)
    {
        $content = $DocInfo->content;
        $articleArr = array();
        $articleUrl = $DocInfo->url;

        //解析每一篇文章
        $match = array();

        $sat = "/<div[^>]*class=\"single_item\"[^>]*>(.*?) <\/div>/si";
        $rgt = preg_match($sat, $content, $match);
        if ($rgt > 0) {
            $articleArr['article'] = $match[1];
        } else {
            $articleArr['article'] = "";
        }
        echo $articleUrl;
        print_r($articleArr);
    }
}


//实例化
$crawler = new MyCrawler();
// URL to crawl
//绑定旅游URL
$start_url="http://www.wvmp360.com/lytc.asp?uid=&brand=";
$crawler->setURL($start_url);

// Only receive content of files with content-type "text/html"
$crawler->addContentTypeReceiveRule("#text/html#");

//链接扩展
//$crawler->addURLFollowRule("#http://www\.kugou\.com/yy/special/single/\d+\.html$# i");
//$crawler->addURLFollowRule("#http://www.kugou\.com/yy/special/index/\d+-\d+-2\.html$# i");

// Store and send cookie-data like a browser does
$crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB(1000 * 1024) (in bytes,
// for testing we dont want to "suck" the whole site)
//爬取大小无限制
$crawler->setTrafficLimit(0);

// Thats enough, now here we go
$crawler->go();

// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
$report = $crawler->getProcessReport();

if (PHP_SAPI == "cli") $lb = "\n";
else $lb = "<br />";

echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb;
