<?php 

Namespace Aboustayyef\ImageGetters;

class ImgTagGetter extends _Getter
{
	
	// available parameters from parent constructor:
	// $crawler, $url, $minsize, $candidateImage

	public function get()
	{
		
		$imageCrawler = $this->crawler->filter('img');
    	
    	if ($imageCrawler->count() > 0)
    	{
    		
    		foreach ($imageCrawler as $key => $image)
    		{
    			
    			$this->candidateImage = $image->getAttribute('src');
    			
    			$dimensions = $this->candidateImageSize();

    			$width = (int) $dimensions['width'];
	    		$min = (int) $this->minsize;
	    	
	    		if ($width > $min) 
	    		{
	    			return $this->candidateImage;
	    		}    		
    		
    		}

    		return false;
   		
    	}
	}
}
?>