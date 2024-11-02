<?php

class Courses {
	public function __construct() {

	}

	public function get_courses($posts_per_page = -1, $user_id = false) {
		if(function_exists('pmpro_courses_get_courses')) {
		return pmpro_courses_get_courses($posts_per_page, $user_id);
		}
		return array();
	}

	public function get_lessons($course_id) {
		
		if(function_exists('pmpro_courses_get_lessons')) {
			return pmpro_courses_get_lessons($course_id);
		}
		return array();
		
	}
}