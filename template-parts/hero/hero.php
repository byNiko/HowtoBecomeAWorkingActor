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
					<?php
				if ($hero_image_link = $args['hero_image_link']): ?>
					<div class="hero-image-overlay mb-lg">
						<button class='button icon text ' data-micromodal-trigger="modal-welcome-video" data-video-url="<?= $hero_image_link['url']; ?>">
							<span class='icon'><?= $playIcon; ?></span>
							<span class='text'><?= $hero_image_link['title']; ?></span>
						</button>
					</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php if(is_front_page()):
	echo makeModal('welcome-video', null);
endif;