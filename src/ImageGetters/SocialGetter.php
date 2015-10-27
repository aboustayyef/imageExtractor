<?php 

Namespace Aboustayyef\ImageGetters;

class SocialGetter extends _Getter{
	
	// available parameters from parent constructor:
	// $crawler, $url, $minsize, $candidateImage

	public function get(){
		
		try {
    
            $imageCrawler = $this->crawler->filter('meta[property="og:image"]');
       
            if ($imageCrawler->count() > 0) {
                
                $this->candidateImage = $imageCrawler->first()->attr('content');

                $dimensions = $this->candidateImageSize();

                $width = (int) $dimensions['width'];
                $min = (int) $this->minsize;

                if ($width > $min) {
                    if ( !in_array($this->candidateImage, $this->disqualified)) {
                        return $this->candidateImage;
                    }
                }
                return false;

            }            
        } catch (Exception $e) {
            return false;
        }
    	return false;
	}

}



?>