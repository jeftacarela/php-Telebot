<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
// use Goutte\Client;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class ScraperController extends Controller
{
    private $results = array();

    public function scraper(Request $request)
    {
        // get url param for scrapping
        $url = $request->get(key:'https://www.zomato.com/jakarta/tebet-restaurants');
        // $page = $client->request(method:'GET', $url);

        //init guzzle
        $client = new Client();
        
        //get req
        $response = $client->request(method:'GET',$url);

        $response_status_code = $response->getStatusCode();
        $html = $response->getBody()->getContents();

        if($response_status_code==200)
        {
            $dom = HtmlDomParser::str_get_html($html);

            $divs = $dom->find(selector: 'div[class="content"]');

            $count = 1;
            foreach ($divs as $div)
            {
                if($count==1)
                {
                    $restoName = trim($div->find(selector:'a[class="result-title"]',idx: 0)->text());
                    dd(trim($restoName->text()));
                    
                    $restoAddress = trim($div->find(selector:'a[class="col-m-16"]',idx: 0)->text());
                    dd(trim($restoAddress->text()));
                    
                    $restoRating = trim($div->find(selector:'a[class="rating-value"]',idx: 0)->text());
                    dd(trim($restoRating->text()));

                } $count++;
            }

        }

        echo "<pre>";
        print_r($url);

        // return view(view: 'scraper');
    }
}
