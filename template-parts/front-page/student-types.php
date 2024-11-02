<div class="container grid vertical-grid">
	<header class="display centered row">
		<div>Where are <span class="text-accent">you</span> on your journey to becoming a working actor?</div>
	</header>
	<div class="grid row">
		<div class="student-types">

			<?php
			require(__DIR__ . '/student-types-data.php');
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'student-type',
				'post_status' => 'publish',
			);
			$student_types = get_posts($args);

			foreach ($student_types as $type):
				$id = trim(sanitize_title($type->post_name));
			?>
				<div class="student-type">
					<h5 class="fw-light"><?= $type->post_title; ?></h5> 
					<figure class="student-type-image" data-micromodal-trigger="modal-<?= $id; ?>">
						<?= get_the_post_thumbnail($type->ID, 'medium'); ?>

						<figcaption class="hover_el">
							<?= get_field('hover_description', $type); ?>
							<footer class="student-type-description">
								<button class="button primary sm">That's Me!</button>
							</footer>
						</figcaption>
					</figure>

				</div>
				<?
				$modal_content = get_field('popup_text', $type);
				$modal_content .= "<footer>" . get_field('popup_footer', $type) .  "</footer>";
				$modal_content .= "<div class='flex centered'>" . get_questionnaire_modal_trigger() . "</div>";
				$modal_title = "<div class='display-sm text-center border-bottom--inner pb-3'>" . get_field('popup_title', $type) . "</div>";

				echo makeModal($id, $modal_content, $modal_title);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php get_template_part('patterns/micromodal'); ?>