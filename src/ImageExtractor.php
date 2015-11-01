<?php

namespace Aboustayyef;

use Symfony\Component\DomCrawler\Crawler;

/**
 *
 *  Image Extractor Class, Mustapha Hamoui
 *  -> takes: url (required) and html content (optional)
 *  -> returns: first image that is wider than given width
 *
 *  Usage:
 *  $test = new \Aboustayyef\ImageExtractor('http://urlhere', 'html content here, optional', $verbose = true or false );
 *  $test->verbose = true; // default is false
 *  echo $test->get(400); // minimum width = 400
 *  
 */


class ImageExtractor
{
    public $disqualified = []; // will ignore an image if it's equal to this variable
	public $content;
    public $crawler;
    public $url; // we always need the url even when content is given, for relative images;
    public $status='ok';
    public $verbose = false;

    public function log($message){
        if ($this->verbose) {
            echo '== ' . $message . PHP_EOL ;
        }
    }

    public function disqualify($url = ''){
        $this->disqualified[] = $url;
    }

    public function getDisqualified(){
        return $this->disqualified;
    }

	public function __construct($url=null, $content=null, $verbose = false){ // url is

        $this->verbose = $verbose;

        $this->log('constructing Extractor');
        // make sure a url is entered
        
        if (!isset($url)) {
            echo 'a url is required as the first parameter';
            $this->status = 'error';
        }

        $this->url = $url;
        // populate content, either from given content (priority) or url
        
        if (!isset($content)) {
            try {
                $this->log('extracting content from ' . $this->url);
                $this->content = @file_get_contents($this->url);
            } catch (Exception $e) {
                echo 'couldn\'t extract url';
                $this->status = 'error';
            }      
        } else {
            $this->log('setting content to injected content');
            $this->content = $content;
            $this->log('adding content of URL');
            $this->content .= @file_get_contents($this->url);
        }

        // make sure content is big enough
        $this->log('Making sure content is large enough');
        if (strlen($this->content) < 10) {
            echo 'this resource\'s content is too small';
            $this->status ='error';
        }

        // Initialize crawler
        $this->log('Initializing the Crawling object and populating it');
        $this->crawler = new Crawler;
        $this->crawler->addHtmlContent($this->content);

	}

    public function get($minsize = 300){

        if ($this->status == 'error') {
            $this->log('There was an error');
            return false;
        }
        
        $this->log('Trying to extract using social tags');
        $candidate = (new ImageGetters\SocialGetter($this))->get(300);
        if ($candidate) {
            // echo "Method Used: Social Getter";
            return $candidate;
        }

        // try for content images (using <img> tag)
        $this->log('Trying to extract using <img> tags');
        $extractor = (new ImageGetters\ImgTagGetter($this));
        $candidate = $extractor->get(300);
        if ($candidate) {
            // echo "Method Used: Img Tag Getter";
            return $candidate;
        }

        // try for youtube embeds previews
        $this->log('Trying to extract using Youtube Metadata');
        $candidate = (new ImageGetters\YoutubePreviewGetter($this))->get();
        if ($candidate) {
            // echo "Method Used: Youtube Image Getter";
            return $candidate;
        }
        return false;
        // try for vimeo images
    }

}
