<?php
require(get_template_directory() . '/parts/svg-icons.php');
?>
<div class="hero">
	<div class="hero-grid copy--<?= $args['text_side']; ?>">
		<div class="hero-copy">
			<h1 class="hero-title"><?= $args['title']; ?></h1>
			<p class="hero-subtitle"><?= $args['subtitle']; ?></p>
			<?php if ($args['link']): ?>
				<div class="centered">
					<?= byniko\get_acf_link($args['link'], "button secondary large"); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php if(is_front_page()): ?> 
			<div class="hero-image ">
				<div class="hero-image-container"
					style="--background:url( <?= $args['hero_image']; ?>), var(--primary-linear-gradient);">
					<div class="hero-image-overlay mb-lg">
						<button class='button icon text ' data-micromodal-trigger="modal-welcome-video" data-video-url="https://vimeo.com/862029895">
							<span class='icon'><?= $playIcon; ?></span>
							<span class='text'>A Welcome From Jim</span>
						</button>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php if(is_front_page()):
	echo makeModal('welcome-video', null);
endif;