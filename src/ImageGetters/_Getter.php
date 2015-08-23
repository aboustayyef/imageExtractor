<?php 

Namespace Aboustayyef\ImageGetters;

abstract class _Getter{
	
	protected $crawler, $url, $minsize;
	protected $candidateImage;

	public function __construct($crawler, $url, $minsize){

		$this->crawler = $crawler;
		$this->url = $url;
		$this->minsize = $minsize;
		$this->candidateImage = null;

	}

	abstract function get();

	public function candidateImageSize(){
		//common code for checking the size of the candidate image

		// first we normalize the url to an absolute url
		$this->normalizeCandidateImageUrl();
		
		// then we check and return the dimensions of the candidate image size;
		$FastImageSize = new \FastImageSize\FastImageSize();
		$imageSize = $FastImageSize->getImageSize($this->candidateImage);
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