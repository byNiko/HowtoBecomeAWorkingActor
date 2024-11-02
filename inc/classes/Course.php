<?php

class Course {
	public $id, $ID;
	public $post;
	public function __construct($course_id) {
		
		$this->id = $course_id;
		$this->ID = $this->id;
		$this-> post =  get_post($course_id);
	}

public function get_welcome_video() {
	$video = get_field('welcome_video_link',$this->ID);
	if($video) {
		$this->welcome_video = wp_oembed_get($video);
		return $this->welcome_video;
	}
}	
	public function the_welcome_video() {
		$this->get_welcome_video();
		if($this->welcome_video) {
			echo $this->welcome_video;
		}
	}
	public function get_lessons() {
		
		if(function_exists('pmpro_courses_get_lessons')) {
			return pmpro_courses_get_lessons($this->ID);
		}
		echo "no lessons";
		return array();
		
	}
}