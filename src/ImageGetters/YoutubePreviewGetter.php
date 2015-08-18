<?php 

Namespace Aboustayyef\ImageGetters;

class YoutubePreviewGetter extends _Getter
{
	
	// available parameters from parent constructor:
	// $crawler, $url, $minsize, $candidateImage

	public function get()
	{
		
        $htmlContent = $this->crawler->filter('body')->html();
      
        preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $htmlContent, $matches);

        if(isset($matches[2]) && $matches[2] != '')
        {
            $YoutubeCode = $matches[2];

            $this->candidateImage = 'http://img.youtube.com/vi/'.$YoutubeCode.'/0.jpg';

            // check if image still exists
            
            if (@getimagesize($this->candidateImage)) 
            {
              return $this->candidateImage;
            }

            return false;
      }
	}
}
?>