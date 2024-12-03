<?php
namespace byniko_membership;

require_once(__DIR__ . '/require_membership_for_terms.php');
require_once(__DIR__ . '/bonus_lesson_filter.php');

function addRestrictedVideOverlay($content, $is_restricted) {
	if(!$is_restricted) return '';

	return "
	<div class='restricted-video-overlay'>
	<div class='inner-container'>
<div class='restriction-notification'>Join the Masterclass to access all Bonus Lessons.</div>
	</div>
	</div>"; 
}
