</main>
</section>

<footer class="site-footer" id="site-footer">
	<div class="container">
		<div class="row flex-row">
			<div class="column">
				<a class="brand footer-brand" href="<?php echo site_url(); ?>">
					<span class="subtitle"><?= get_bloginfo('name'); ?> </span>
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