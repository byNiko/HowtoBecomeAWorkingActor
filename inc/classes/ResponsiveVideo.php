<?php
class ResponsiveVideo {
	public $video_id, $video_url, $video_meta, $width, $height, $autoplay, $mute, $aspect_ratio;
	public $args = array(
		'video_id' => null,
		'video_url' => null,
		'width' => 640,
		'height' => 480,
		'autoplay' => true,
		'mute' => true,
	);
	public function __construct($args) {
		$args = array_merge($this->args, $args);
		$this->video_url = $args['video_url'];
		$this->video_id = $args['video_id'];
		
		if (!$this->video_id && $this->video_url) {
			$this->video_id = $this->getVimeoVideoIdFromUrl($this->video_url);
		}
		if ($this->video_url) {
			$this->get_video_meta();
			$this->width = $this->video_meta['width'];
			$this->height = $this->video_meta['height'];
			$this->autoplay = $args['autoplay'];
			$this->aspect_ratio = $this->width . '/' . $this->height;
			$this->mute = $args['mute'];
		} 
	}
	public function get_video_meta() {
	
		$url = "https://vimeo.com/api/oembed.json?url=$this->video_url";

		$obj = json_decode(file_get_contents($url), true);
		if($obj) {
			$this->video_meta = $obj;
		}
		else {
			$this->video_meta = array();
		}
		// echo "<pre>" . print_r($this->video_meta) . "</pre>";
	}
	public function get_video_id() {
		return $this->video_id;
	}
	public function get_video_url() {
		return $this->video_url;
	}

	public function make_iframe() {
		// $html = "<iframe class='responsive-media-item' src='https://player.vimeo.com/video/$this->video_id'  frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
			if(!isset($this->video_meta['html'])) {
				return false;
			}
		$html = $this->video_meta['html']??'';
		return $html;
	}

	private function getVimeoVideoIdFromUrl($url = '') {

		$regs = array();
		$id = '';
		if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
			$id = $regs[3];
		}
		return $id;
	}

	public function get_responsive_video() {
		$iframe = $this->make_iframe();
		$html = false;
		if($iframe) {
		$html = "<div class='responsive-media-container'>";
		$html .= "<div class='responsive-media-wrapper has-radius' style='--aspect-ratio:$this->aspect_ratio;'>";
		$html .=$iframe;
		$html .= "</div>";
		$html .= "</div>";
		}
		// var_dump($html);

		return $html;
	}

	public function the_responsive_video() {
		echo $this->get_responsive_video();
	}
}
