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
 *  $test = new \Aboustayyef\ImageExtractor('http://urlhere', 'html content here, optional');
 *  echo $test->get(400); // minimum width = 400
 *  
 */


class ImageExtractor
{

	protected $content;
    protected $crawler;
    protected $url; // we always need the url even when content is given, for relative images;

	public function __construct($url=null, $content=null){ // url is

        // make sure a url is entered
        
        if (!isset($url)) {
            die('a url is required as the first parameter');
        }

        $this->url = $url;
        // populate content, either from given content (priority) or url
        
        if (!isset($content)) {
            try {
                $this->content = @file_get_contents($this->url);
            } catch (Exception $e) {
                die('couldn\'t extract url');
            }      
        } else {
            $this->content = $content;
        }

        // make sure content is big enough
        if (strlen($this->content) < 10) {
            die('this resource\'s content is too small');
        }

        // Initialize crawler
        
        $this->crawler = new Crawler;
        $this->crawler->addHtmlContent($this->content);

	}


    public function get($minsize = 300){

        // try for social images (facebook open graph and twitter)
        
        $candidate = (new ImageGetters\SocialGetter($this->crawler, $this->url, $minsize))->get();
        if ($candidate) {
            return $candidate;
        }

        // try for content images (using <img> tag)
        $candidate = (new ImageGetters\ImgTagGetter($this->crawler, $this->url, $minsize))->get();
        if ($candidate) {
            return $candidate;
        }

        // try for youtube embeds previews
        $candidate = (new ImageGetters\YoutubePreviewGetter($this->crawler, $this->url, $minsize))->get();
        if ($candidate) {
            return $candidate;
        }

        // try for vimeo images
    }

}