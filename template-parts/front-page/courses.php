<?php
// require(__DIR__ . '/courses-data.php');
require(get_template_directory() . '/parts/svg-icons.php');
$Courses = new Courses();
?>
<div class="grid vertical-grid">
	<?php
	foreach ($Courses->get_courses() as $course):
	?>
		<div class="container light-md has-shadow">
			<div class="grid has-sidebar row grid-400 align-start">
				<div class="course-content main">
					<header>
						<h2 class="display-sm"><?php echo $course->post_title; ?></h2>
					</header>
					<div class="content fz-mds">
						<p><?= apply_filters('the_content', $course->post_excerpt); ?></p>
						<p class="text-right text-underline">
							<a class="button secondary " href="<?= get_permalink($course->ID); ?>">Start <?= $course->post_title; ?>!</a>
						</p>
					</div>
				</div>
				<aside class="lessons-list">
					<div class="inner-lessons-list grid grid-vertical">
						<?php
						if ($welcome_url = get_field('welcome_video_link', $course->ID)):
							$id = trim(sanitize_title($welcome_url));
							echo makeModal($id, null);
						?>
							<div class="lesson-item-wrap "
								data-micromodal-trigger="modal-<?= $id; ?>"
								data-video-url="<?= $welcome_url; ?>">
								<div class="lesson-title-wrap">
									<span class='lesson-icon'><?= $playIcon; ?></span>
									<div class="lesson-title">Course Trailer</div>
								</div>
							</div>
						<?php endif; ?>
						<?php
						if ($sample_url = get_field('sample_video_link', $course->ID)):
							$id = trim(sanitize_title($sample_url));
							echo makeModal($id, null);
						?>
							<div class="lesson-item-wrap "
								data-micromodal-trigger="modal-<?= $id; ?>"
								data-video-url="<?= $sample_url; ?>"
								?>
								<div class="lesson-title-wrap">
									<span class='lesson-icon'><?= $playIcon; ?></span>
									<div class="lesson-title">Course Sample</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if (1 === 2): ?>
							<small class="fw-bold text-uppercase mt-3">lessons</small>
							<ol class="accordion-items lesson-items">
								<?php
								$counter = 0;
								foreach ($Courses->get_lessons($course->ID) as $lesson => $lesson_data):
									$counter++;
								?>
									<li class="lesson-item-wrap lesson accordion ">
										<header class="lesson-title-wrap accordion-trigger">
											<span class="counter"><?= $counter ?>.</span>
											<span class='lesson-title'><?= $lesson_data->post_title; ?></span>
											<span class="lesson-icon"><?= $caret; ?></span>
										</header>
										<div class="lesson-description accordion-content">
											<?php echo apply_filters('the_content', $lesson_data->post_content); ?>
										</div>
									</li>
								<?php endforeach; ?>
							</ol>
						<?php endif; ?>
					</div>
				</aside>
			</div>
		</div>
	<?php endforeach; ?>
</div>