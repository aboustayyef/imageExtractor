<?php 

Namespace Aboustayyef\ImageGetters;

class SocialGetter extends _Getter{
	
	// available parameters from parent constructor:
	// $crawler, $url, $minsize, $candidateImage

	public function get(){
		
		$imageCrawler = $this->crawler->filter('meta[property="og:image"]');
    	
    	if ($imageCrawler->count() > 0) {
    		
    		$this->candidateImage = $imageCrawler->first()->attr('content');

    		$dimensions = $this->candidateImageSize();

    		$width = (int) $dimensions['width'];
    		$min = (int) $this->minsize;

    		if ($width > $min) {
                echo "Disqualified: $this->disqualified" . PHP_EOL;
                if ($this->candidateImage != $this->disqualified) {
                    return $this->candidateImage;
                }
    		}
    		return false;

    	}
    	return false;
	}

}



?>