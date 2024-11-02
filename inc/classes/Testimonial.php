<?php

class Testimonial{
	public $post;
	public $ID;
	public function __construct($post) {
		$this->post = $post;
		$this->ID = $post->ID;

	}
	public function get_image() {
		return get_the_post_thumbnail($this->post->ID,'medium'); 
	}

	public function get_name() {
		return $this->post->post_title;
	}
	public function get_quote() {
		return get_field('quote', $this->post);
	}
	public function get_citation_1() {
		$text = get_field('quote_citation_line_1', $this->post)?: get_the_title($this->post->ID);
		return $text;
	}	
	public function get_citation_2() {
		return get_field('quote_citation_line_2', $this->post) ;
	}	
	public function get_image_caption_1() {
		return get_field('image_caption_line_1', $this->post) ;
	}	
	public function get_image_caption_2() {
		return get_field('image_caption_line_2', $this->post) ;
	}	

	public function get_source($key = 'slug') {
		return get_the_terms( $this->ID, 'source' )[0]->$key ;
	}
}