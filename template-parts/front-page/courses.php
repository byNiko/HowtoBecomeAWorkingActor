<?php
// require(__DIR__ . '/courses-data.php');
require(get_template_directory() . '/parts/svg-icons.php');
$Courses = new Courses();
?>
<div class="grid vertical-grid">
	<?php
	foreach ($Courses->get_courses() as $course):
		if($course->post_title === "Free Lessons") continue;
		if($course->post_title === "Bonus Lessons") continue;
	?>
		<article class="container light-md has-shadow">
			<div class="row">
				<header>
					<h2 class="display-sm"><?php echo $course->post_title; ?></h2>
				</header>
			</div>
			<div class="grid grid-50-50 row  align-start">
				<div class="course-content main">

					<div class="content fz-mds">
						<?php $extended = get_extended($course->post_content); ?>
						<p><?= apply_filters('the_content', $extended['main']); ?></p>
						<p class="text-center text-underline">
							<a class="button secondary " href="<?= get_permalink($course->ID); ?>">Learn More!</a>
						</p>
					</div>
				</div>
				<aside class="lessons-list">
					<div class="inner-lessons-list grid grid-vertical">
						<?php
						if ($welcome_url = get_field('welcome_video_link', $course->ID)):
							$id = trim(sanitize_title($welcome_url));
							//echo makeModal($id, null);
						?>
						
						<div data-iframe-url="<?= $welcome_url; ?>">
						</div>
							<div class="lesson-item-wrap d-none"
								data-micromodal-trigger="modal-<?= $id; ?>"
								data-video-url="<?= $welcome_url; ?>">
								<div class="lesson-title-wrap">
									<span class='lesson-icon'><?= $playIcon; ?></span>
									<div class="lesson-title">Courses Trailer</div>
								</div>
							</div>
						<?php endif; ?>
						<?php
						if ( 1 === 2 && $sample_url = get_field('sample_video_link', $course->ID)):
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
		</article>
	<?php endforeach; ?>
</div>