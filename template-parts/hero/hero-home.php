<?php
require (get_template_directory() . '/parts/svg-icons.php');
?>
<div class="hero">
	<div class="hero-grid">
		<div class="hero-copy">
			<h1 class="hero-title"><span class="text-accent">Mentorship</span> for the Business of Acting</h1>
			<p class="hero-subtitle">If your passion in life is to become a working actor, I want to help you get there.
			</p>
			<div class="centered">
				<a href="#sign-up" class="button secondary large">
					Let's Start Working!
				</a>
			</div>
		</div>
		<div class="hero-image">
			<div class="hero-image-container"
				 style="--background: url(<?= $args['hero_image']; ?>);">
				<!-- <img src="<?php //echo get_template_directory_uri(); ?>/src/media/jim_black_white_hands.jpg" alt="hero image" style="background-image: url(<?php echo get_template_directory_uri(); ?>/src/media/jim_black_white_hands.jpg)"> -->
				<div class="hero-image-overlay mb-lg">
					<button class='button icon text fz-sm' data-micromodal-trigger="modal-welcome-video" data-video-url="https://vimeo.com/1061884719/643263f7d0?share=copy">
						<span class='icon'><?= $playIcon; ?></span>
						<span class='text'>A Welcome From Jim</span>
					</button>
				</div>
				<?= 
				//$iframe = makeIframe('https://www.youtube.com/embed/3-5w7M6a7o8?autoplay=1&mute=1', 'welcome-video');
				makeModal('welcome-video', null); 
				?>
			</div>
		</div>
	</div>
</div>