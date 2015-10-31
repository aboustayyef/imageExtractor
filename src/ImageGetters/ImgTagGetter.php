<?php 

Namespace Aboustayyef\ImageGetters;

class ImgTagGetter extends _Getter
{
	// gets largest image in page
	// available parameters from parent constructor:
	// $crawler, $url, $minsize, $candidateImage

	public function get($minsize=300)
	{

		$imageCrawler = $this->crawler->filter('img');
    	
    	if ($imageCrawler->count() > 0)
    	{
    		$largestImage = null;
            $lastImageArea = 0;

    		foreach ($imageCrawler as $key => $image)
    		{
    			
    			$this->candidateImage = $image->getAttribute('src');
                $this->imageExtractor->log('Trying image ' . $this->candidateImage);
                // skip if is equal to disqualified image
                if (in_array($this->candidateImage, $this->disqualified) ) {
                    $this->imageExtractor->log('-- This image is disqualified');
                    continue;
                }
  			
                // get Image's dimensions
    			
                $dimensions = $this->candidateImageSize();
    			$width = $dimensions['width'];
                $height = $dimensions['height']; 
                if ($height == 0) {
                    $this->imageExtractor->log('Could Not get image Dimensions');
                    continue;
                }
                $ratio = $width / $height;

                $this->imageExtractor->log("-- Image Dimensions: Width: $width, Height: $height, Ratio: $ratio");
	    		$min = $this->minsize;
 	    	
	    		if (($width > $min) && ($ratio < 3.5)) 
	    		{
                    if (($width * $height) > $lastImageArea) {
                        $lastImageArea = $width * $height;
                        $largestImage = $this->candidateImage;
                        $this->imageExtractor->log('-- This is now the largest image');
                    }
	    		}
                else
                {
                    $this->imageExtractor->log('-- Image too small or too wide');
                }    		
    		
    		}

            if ($largestImage) {
                $this->imageExtractor->log('-- We Have a winner');
                return $largestImage;
            } 	
    	}

        return false;

	}
}
?>