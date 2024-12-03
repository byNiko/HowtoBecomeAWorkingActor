<?php

class Lesson {
	public $id, $ID;
	public $post;
	public $bonus_access_levels, $free_bonus_access_levels;
	public function __construct($lesson_id) {

		$this->id = $lesson_id;
		$this->ID = $this->id;
		$this->post =  get_post($lesson_id);
		$this->free_bonus_access_levels = array(2); // required levels for access bonus lessons of free category		
		$this->bonus_access_levels = array(2,3); // required levels for access to all bonus lessons 
	}


	public function get_lessons() {

		if (function_exists('pmpro_courses_get_lessons')) {
			return pmpro_courses_get_lessons($this->ID);
		}
		return array();
	}

	public function get_course_id() {
		return wp_get_post_parent_id($this->ID);
	}



	/**
	 * The function `get_main_video` retrieves the lesson's main video URL from a custom field and generates a
	 * responsive video player using the `ResponsiveVideo` class.
	 * 
	 * @return string a responsive video snippet 
	 */
	public function get_main_video($is_restricted = false) {
		$video_args = array(
			'video_url' => get_field('lesson_video_url', $this->id),
		);
		$v = new ResponsiveVideo($video_args);
		// var_dump($is_restricted);
		if ($is_restricted) {
			add_filter('byniko_before_responsive_media_wrapper','byniko_membership\addRestrictedVideOverlay', 10, 2);
		}
		return $v->get_responsive_video($is_restricted);
	}


	/**
	 * is_bonus_lesson checks if the lesson is a bonus lesson by checking if it has the 'bonus' term assigned to it.
	 * @return boolean true if the lesson is a bonus lesson, false otherwise.
	 */
	public function is_bonus_lesson() {
		$post_id = $this->id;
		$bonus_slug = 'bonus';

		$is_bonus = false;

		$post_terms = get_the_terms($post_id, 'lesson-category');
		if (is_array($post_terms)) :
			foreach ($post_terms as $term):
				if ($term->slug === $bonus_slug) {
					$is_bonus = true;
				}
			endforeach;
		endif;
		return $is_bonus;
	}

	/** 
	 * The function checks if a bonus lesson is restricted based on its associated terms, allowing access
	 * if it contains a specific term with the slug 'free'.
	 * 
	 * @return boolean `is_restricted_bonus_lesson()` is returning a boolean value indicating whether
	 * a bonus lesson is restricted or not. If the bonus lesson is not restricted, it will return `false`,
	 * otherwise it will return `true`.
	 */
	public function is_restricted_bonus_lesson() {
		$post_id = $this->id;
		if (!$this->is_bonus_lesson()) return false;

		$is_restricted = true;
		$free_bonus_slugs = array('free');

		$restriction_array = array(
			'free' => 2, // membership level required to access
			'bonus' => 3, // membership level required to access
		);

		$post_terms = get_the_terms($post_id, 'lesson-category');
		/* 
		if the terms associated with a post (lesson) contain a specific term
		with the slug 'free' then is is NOT restricted. 
		*/
		if (is_array($post_terms)) :
			foreach ($post_terms as $term):
				if (in_array($term->slug, $free_bonus_slugs)) {
					$is_restricted = false;
				}
			endforeach;
		endif;
		return $is_restricted;
	}

	function get_required_access_level() {
		$free_bonus_access_levels = $this->free_bonus_access_levels;
		$bonus_access_levels = $this->bonus_access_levels;
		if ($this->is_restricted_bonus_lesson($this->id)) {
			return $bonus_access_levels;
		}
		return $free_bonus_access_levels;
	}

	public function member_has_access_to_bonus_lesson($bonus_level_access = null) {
		$lesson_id = $this->id;
		// if (!is_user_logged_in()) return false;

		if ($this->is_restricted_bonus_lesson($lesson_id)):
			$access_levels = $bonus_level_access ?: $this->bonus_access_levels;

			return byniko\has_membership_level($access_levels);
		endif;
		return true;
	}
}
