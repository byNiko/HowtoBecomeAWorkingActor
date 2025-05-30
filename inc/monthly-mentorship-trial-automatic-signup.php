<?php

function working_add_monthly_with_lifetime($level_id, $user_id) {

	$lifetime_id = '2'; // Replace with your actual Lifetime Membership ID
	$monthly_id = '3';  // Replace with your actual Monthly Membership ID

	if (function_exists('pmpro_changeMembershipLevel') && class_exists('PMPro_Membership_Level')) {

		if ($level_id == $lifetime_id) {
			// Set expiration date 12 months from today
			$expiration = date("Y-m-d", strtotime("+12 months"));
			// Set expiration date 12 months from now
			$expiration = date("Y-m-d, H:i:s", strtotime("+1 minute"));

			// Build level array for setMembershipLevelForUser()
			$level = array(
				'membership_id' => $monthly_id,
				'user_id' => $user_id,
				'startdate' => current_time('mysql'),
				'enddate' => $expiration
			);

			// Add the level with expiration
			pmpro_changeMembershipLevel($level, $user_id);
		}
	} else {
		error_log("Problem signing up $user_id. pmpro_changeMembershipLevel() OR ()) is not available. Called from " . __FILE__ );
		$admin_email = get_option('admin_email');
		$subject = 'HowToBecomeAWorkingActor SignUp Error Detected';

		$message = "An error occurred on the site:\n\n";
		$message .= "Error Message: " . "Problem signing up $user_id because pmpro_changeMembershipLevel() or PMPro_Membership_Level is not available. Called from " . __FILE__ . "\n\n";
		$message .= "Timestamp: " . date('Y-m-d H:i:s');

		wp_mail($admin_email, $subject, $message);
	}
}
add_action('pmpro_after_change_membership_level', 'working_add_monthly_with_lifetime', 10, 3);


add_action('pmpro_membership_post_membership_expiry', 'working_email_membership_expiry', 10, 2);
function working_email_membership_expiry($user_id, $expired_level_id) {
	$free_trial_id = 3; // trial level
	if ($expired_level_id == $free_trial_id) {
		// Optionally downgrade or notify the user
		wp_mail(
			get_userdata($user_id)->user_email,
			'Your trial has ended – Subscribe now!',
			'Your 12-month trial has ended. Click here to subscribe to continue access.'
		);
	}
}


// add_action('pmpro_account_bullets_top', 'f25_show_membership_expired_notice');

function f25_show_membership_expired_notice() {
	$user_id = get_current_user_id();

	if (!$user_id) {
		return;
	}

	global $wpdb;
	// var_dump(pmpro_getMembershipLevelsForUser($user_id)); 

	// Query for the most recent expired membership
	$expired_membership = $wpdb->get_row(
		$wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}pmpro_memberships_users
             WHERE user_id = %d AND enddate IS NOT NULL AND enddate < NOW()
             ORDER BY enddate DESC
             LIMIT 1",
			$user_id
		)
	);

	if ($expired_membership) {
		$level_name = new PMPro_Membership_Level($expired_membership->membership_id)->name ?? 'membership';
		$formatted_date = date_i18n(get_option('date_format'), strtotime($expired_membership->enddate));
		echo add_filter('ssss', 'test', 10, 2);
		echo '<div class="pmpro_message pmpro_alert">';
		echo esc_html("Your {$level_name} expired on {$formatted_date}.");
		echo '</div>';
	}
}
/**
 * Display member's membership expiration date on their account page.
 */
function pmpro_display_expiration_date_revised() {
	global $pmpro_member;
// 	var_dump($pmpro_member);
// echo "hello";
	if (is_user_logged_in() && ! empty($pmpro_member)) {
		if (! empty($pmpro_member->membership_level->name) && ! empty($pmpro_member->expire)) {
			$expiration_date = date_i18n(get_option('date_format'), strtotime($pmpro_member->expire));
			echo '<div class="pmpro_member_expiration">';
			echo '<p>Your <span class="pmpro_level_name">' . esc_html($pmpro_member->membership_level->name) . '</span> membership expired on: <span class="pmpro_expiration_date">' . esc_html($expiration_date) . '</span></p>';
			echo '</div>';
		} elseif (! empty($pmpro_member->membership_level->name) && $pmpro_member->expire == '0000-00-00 00:00:00') {
			echo '<div class="pmpro_member_expiration">';
			echo '<p>Your <span class="pmpro_level_name">' . esc_html($pmpro_member->membership_level->name) . '</span> membership does not have an expiration date.</p>';
			echo '</div>';
		}
	}
}
add_action('pmpro_account_after_membership_level', 'pmpro_display_expiration_date_revised');
