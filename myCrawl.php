<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8
 * Time: 11:24
 */

include("libs/PHPCrawler.class.php");

//set_time_limit(1000);

class MyCrawler extends PHPCrawler
{
    function handleDocumentInfo(PHPCrawlerDocumentInfo $PageInfo)
    {
        // Your code comes here!
        // Do something with the $PageInfo-object that
        // contains all information about the currently
        // received document.

        // As example we just print out the URL of the document
//        echo $PageInfo->url."\n";
        // Print the URL of the document <all url>
//        echo "URL: ".$PageInfo->url."<br />";

        // Print the http-status-code
//        echo "HTTP-statuscode: ".$PageInfo->http_status_code."<br />";
//
//        // Print the number of found links in this document
//        echo "Links found: ".count($PageInfo->links_found_url_descriptors)."<br />";
//
//        //
        echo "content:" .$PageInfo->content.'<br/>';
//        echo "referInfo:" .$PageInfo->referer_url.'<br/>';
    }
}

$crawler = new MyCrawler();
$crawler->setURL("www.baidu.com");
$crawler->addContentTypeReceiveRule("#text/html#");
// ...

$crawler->go();
// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
$report = $crawler->getProcessReport();