<?php
namespace byniko_membership;
/**
 * Require Membership to View Certain Taxonomy Terms
 * E.g., the example code here locks down posts in the custom taxonomy 'dietary_requirements' with the 'Keto' term.
 * Note we hook in on priority 15 to run after other filters.
 */
// add_filter( 'pmpro_has_membership_access_filter', 'byniko_membership\require_membership_for_terms', 15, 4 );
function require_membership_for_terms( $hasaccess, $post, $user, $post_levels ) {

	// Make sure we have a post to check.
	if ( empty( $post ) || empty( $post->ID ) ) {
		return $hasaccess;
	}
	
	// First array's keys are taxonomy names.
	// Second array's keys are term slugs.
	// Second array's values are arrays of level IDs.
	$term_levels = array(
		'lesson-category' => array(
			'bonus' => array(3),
			'free' => array(2)
		),
	);

	foreach ( $term_levels as $taxonomy => $terms ) {
		foreach( $terms as $term => $level_ids ) {
			if ( has_term( $term, $taxonomy, $post ) ) {
				// Post has term, lock it down.
				$hasaccess = false;
				if ( pmpro_hasMembershipLevel( $level_ids, $user->ID ) ) {
					// User has level, unlock it again.
					$hasaccess = true;	// Give access.
					break 2;			// Break both for loops.
				}
			}
		}
	}
	
	return $hasaccess;
}
