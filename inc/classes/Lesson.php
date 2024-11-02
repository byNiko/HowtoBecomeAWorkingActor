<?php

class Lesson {
	public $id, $ID;
	public $post;
	public function __construct($lesson_id) {
		
		$this->id = $lesson_id;
		$this->ID = $this->id;
		$this-> post =  get_post($lesson_id);
	}


	public function get_lessons() {
		
		if(function_exists('pmpro_courses_get_lessons')) {
			return pmpro_courses_get_lessons($this->ID);
		}
		return array();
		
	}

	public function get_course_id() {
		return wp_get_post_parent_id( $this->ID );
	}
}