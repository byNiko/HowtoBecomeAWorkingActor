<?php
namespace byniko_membership;

function bonus_lesson_content($lesson) {
	// $content = get_the_content($lesson->id);
	$content = "";
	$has_access = $lesson->member_has_access_to_bonus_lesson();
	$required_access_level = $lesson->get_required_access_level();
	$restrict = !$has_access;
	$content = $lesson->get_main_video($restrict) . $content;
	return apply_filters('the_content', $content);	
}

