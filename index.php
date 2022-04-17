<?php

include 'simple_html_dom.php';

$url = "https://www.amazon.com/s?k=Over-Ear+Headphones&i=electronics&rh=n%3A12097479011&page=2&c=ts&qid=1649857326&ts_id=12097479011&ref=sr_pg_2";

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" . // i.e. An iPad
              "referer: https://www.amazon.com/"
  )
);

$context = stream_context_create($options);

$anasayfa_url_get = file_get_html($url, false, $context);


for ($i=0; $i < 20 ; $i++)
{

  $sayfa_next_url="https://www.amazon.com".$anasayfa_url_get->find('.s-pagination-item.s-pagination-next',0)->href;

  if ($i != 0)
    $sayfa_next_url="https://www.amazon.com".$sayfa_next_get->find('.s-pagination-item.s-pagination-next',0)->href;


  $sayfa_next_get = file_get_html($sayfa_next_url, false, $context);

  if ($i == 0)
    $urunler = $anasayfa_url_get->find('.s-result-item.s-asin');

  $urunler = array_merge($urunler,$sayfa_next_get->find('.s-result-item.s-asin'));


}

foreach ($urunler as $key => $value)
{

  $key++;
  $asin = $value->getAttribute('data-asin');

  if (!empty($asin))
    echo $key."- ".$asin."<br>";

}


?>
