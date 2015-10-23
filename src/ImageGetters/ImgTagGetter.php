<?php 

Namespace Aboustayyef\ImageGetters;

class ImgTagGetter extends _Getter
{
	// gets largest image in page
	// available parameters from parent constructor:
	// $crawler, $url, $minsize, $candidateImage

	public function get()
	{
		
		$imageCrawler = $this->crawler->filter('img');
    	
    	if ($imageCrawler->count() > 0)
    	{
    		$largestImage = null;
            $lastImageArea = 0;

    		foreach ($imageCrawler as $key => $image)
    		{
    			
    			$this->candidateImage = $image->getAttribute('src');

                // skip if is equal to disqualified image
                if ($this->candidateImage == $this->disqualified) {
                    continue;
                }
  			
                // get Image's dimensions
    			
                $dimensions = $this->candidateImageSize();
    			$width = $dimensions['width'];
                $height = $dimensions['height']; 
	    		$min = $this->minsize;
 	    	
	    		if ($width > $min) 
	    		{
                    if (($width * $height) >= $lastImageArea) {
                        $lastImageArea = $width * $height;
                        $largestImage = $this->candidateImage;
                    }
	    		}    		
    		
    		}

            if ($largestImage) {
                return $largestImage;
            }
		
    	}

        return false;

	}
}
?>