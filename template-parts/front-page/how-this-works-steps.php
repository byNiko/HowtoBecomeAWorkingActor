<?php require(__DIR__ . '/steps-data.php'); ?>
<header>
	<div class="container light no-padding">
		<div class="row">
			<h2 class="display centered text-uppercase">
				How This Works
			</h2>

		</div>
	</div>
</header>

<!-- <div class="container light narrow">
	<div class="row">
		<header>
			<h3 class="subdisplay centered text-underline">
				How this works
			</h3>
		</header>
		<p class="fz-md">
			I meet with every potential student before getting access to these courses. This road isn’t easy and I want to make sure you’re a good fit for this program.
		</p>
	</div>
</div> -->

<div class="container bold narrow">

	<div class="row ">
		
		<p class="fz-sml fw-light border-bottom--inner pb-10 mb-10 small-reading-width">
			I meet with every potential student before getting access to these courses. This road isn’t easy and I want to make sure you’re a good fit for this program.
		</p>
	</div>
	<div class="row">
		<ul class="how-this-works-steps no-style">
			<?php
			$count = 0;
			foreach ($steps as $step => $step_data):
				$count++;
			?>
				<li class="how-this-works-step">
					<div class='step-count'><?= $count; ?> </div>
					<div class="how-this-works-step-title">
						<span class='step-title'><?= $step_data['title']; ?></span>
					</div>
					<div class="how-this-works-step-description">
						<?= $step_data['description']; ?>
						<?php if (isset($step_data['cta'])) : ?>
							<div class="how-this-works-step-cta">
								<?php the_questionnaire_modal_trigger('button secondary', 'Let\'s Get Started'); ?>
							</div>
						<?php endif; ?>
						<?php if (isset($step_data['price'])) : ?>
							<div class="pricing invert">
								<div class="how-this-works-step-price"><?= byniko\get_courses_price(); ?></div>
								<?php if (isset($step_data['benefits'])) : ?>
									<ul class="how-this-works-step-benefits">
										<?php foreach ($step_data['benefits'] as $benefit): ?>
											<li><?= $benefit; ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>


				</li>
			<?php endforeach; ?>
		</ul>

		<div class="centered flex-row how-this-works-step-cta">
		<?php the_questionnaire_modal_trigger('button secondary', 'Let\'s Get Started'); ?>
		</div>
	</div>
</div>