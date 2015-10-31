<?php 

Namespace Aboustayyef\ImageGetters;

abstract class _Getter{
	
	protected $crawler, $url, $minsize;
	protected $candidateImage;
	protected $disqualified;
	protected $imageExtractor;

	public function __construct($imageExtractor) {

		$this->imageExtractor = $imageExtractor;
		$this->crawler = $imageExtractor->crawler;
		$this->url = $imageExtractor->url;
		$this->disqualified = $imageExtractor->disqualified;
		$this->candidateImage = null;

	}

	abstract function get($minsize = 300);

	public function candidateImageSize(){
		//common code for checking the size of the candidate image

		// first we normalize the url to an absolute url
		$this->normalizeCandidateImageUrl();
		
		// then we check and return the dimensions of the candidate image size;


		/*if ($this->fastExtraction) {
			echo 'Extracting dimensions using fast extraction' . PHP_EOL;
			$FastImageSize = new \FastImageSize\FastImageSize();
			$imageSize = $FastImageSize->getImageSize($this->candidateImage);
			return $imageSize;
		}*/

		$image = @getImageSize($this->candidateImage);
		$imageSize = [];
		$imageSize['width'] = $image[0];
		$imageSize['height'] = $image[1];
		return $imageSize;


	}



	public function normalizeCandidateImageUrl(){
		

		$ImageUrlParts = parse_url($this->candidateImage);

		// if url is not absolute, fix it;

		if (!isset($ImageUrlParts['scheme'])) {
			$urlParts = parse_url($this->url);
			$rootUrl = $urlParts['scheme'].'://'.$urlParts['host'];
			$this->candidateImage = $rootUrl . $ImageUrlParts['path'];
		}

		// add query if it exists

		if (isset($ImageUrlParts['query'])) {
			$this->candidateImage = $this->candidateImage . '?' . $ImageUrlParts['query'];
		}

	}

}



?>