<?php
   
    class Easy_rssReader
    {
        private $url;
        private $data;
        
        function __construct($url)
        {
            $this->url;
            $this->data = implode ("", file ($url));
        }
        function obtener_items (){
            preg_match_all ("/<item .*>.*<\/item>/xsmUi", $this->data, $matches);
            $items = array ();
            foreach ($matches[0] as $match)
            {
                $items[] = new RssItem ($match);
            }
            return $items;
        }
    }
  
    class RssItem 
    {
        private $title, $url, $description, $pubDate;
        
        function __construct($xml){
            $this->populate ($xml);
        }
        
        function populate ($xml){
            preg_match ("/<title> (.*) <\/title>/xsmUi", $xml, $matches);
            $this->title = $matches[1];
            preg_match ("/<link> (.*) <\/link>/xsmUi", $xml, $matches);
            $this->url = $matches[1];
            preg_match ("/<description> (.*) <\/description>/xsmUi", $xml, $matches);
            $this->description = $matches[1];
            preg_match ("/<pubDate> (.*) <\/pubDate>/xsmUi", $xml, $matches);
            $this->pubDate = $matches[1];
        }
        
        function obtener_titulo (){
            return $this->title;
        }
        
        function obtener_url (){
            return $this->url;
        }
        
        function obtener_description (){
            return $this->description;
        }
        
        function obtener_pubDate (){
            return $this->pubDate;
        }
    }
    
    /*$f = ROOT."public".DS.'rss_news.xml';
    //$this->getLibrary("Easy_rssReader");
    $news = new Easy_rssReader($f);      
          
    foreach ($news->obtener_items () as $item){
        printf ('<a target="_BLANK" href="%s">%s</a><br />', $item->obtener_url (), $item->obtener_titulo ());
    }               */            

    
 /*   //$RSS = new LectorRSS ("http://www.tublogenwordpress.com/blog/feed/rss/";
$RSS = new LectorRSS ("http://www/public/rss_news.xml");
class LectorRSS {
    var $url;
    var $data;
    
    function LectorRSS ($url){
        $this->url;
        $this->data = implode ("", file ($url));
    }
    
    function obtener_items (){
        preg_match_all ("/<item .*>.*<\/item>/xsmUi", $this->data, $matches);
        $items = array ();
        foreach ($matches[0] as $match){
            $items[] = new RssItem ($match);
        }
        return $items;
    }
}
class RssItem {
    var $title, $url;
    
    function RssItem ($xml){
        $this->populate ($xml);
    }
    
    function populate ($xml){
        preg_match ("/<title> (.*) <\/title>/xsmUi", $xml, $matches);
        $this->title = $matches[1];
        preg_match ("/<link> (.*) <\/link>/xsmUi", $xml, $matches);
        $this->url = $matches[1];
    }
    
    function obtener_titulo (){
        return $this->title;
    }
    
    function obtener_url (){
        return $this->url;
    }
}

foreach ($RSS->obtener_items () as $item){
    printf ('<a target="_BLANK" href="%s">%s</a><br />',
    $item->obtener_url (), $item->obtener_titulo ());
}                  */
?>