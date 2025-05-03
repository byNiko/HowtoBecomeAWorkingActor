</main>
</section>
<button id="back-to-top-button" class="back-to-top"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 64 64" aria-hidden="true" role="img" class="iconify iconify--emojione-monotone" preserveAspectRatio="xMidYMid meet"><path d="M32 2C15.432 2 2 15.432 2 32s13.432 30 30 30s30-13.432 30-30S48.568 2 32 2zm5.143 28.305V49H26.857V30.305H16L32 15l16 15.305H37.143z" fill="#000000"/></svg></button>
<footer class="site-footer" id="site-footer">
	<div class="container">
		<div class="row flex-row">
			<div class="column">
				<a class="brand footer-brand" href="<?php echo site_url(); ?>">
					<span class=""><?= get_bloginfo('name'); ?> </span>
				</a>
			</div>
			<div class="flex-row">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-2',
						'menu_id'        => 'footer-menu-2',
						'menu_class' 	=> "footer-menu footer-menu-3 no-style",
						'container' 		=> 'nav',
						'container_class' 	=> 'footer-menu',
						'container_id' 	=> '',
					)
				);
				wp_nav_menu(
					array(
						'theme_location' => 'footer-3',
						'menu_id'        => 'footer-menu-3',
						'menu_class' 	=> "footer-menu footer-menu-3 no-style",
						'container' 		=> 'nav',
						'container_class' 	=> 'footer-menu',
						'container_id' 	=> '',
					)
				);
				?>
			</div>
		</div>
	</div>
</footer>
<?php echo get_questionnaire_modal(); ?>

<?php wp_footer(); ?>


</div>
</body>

</html>