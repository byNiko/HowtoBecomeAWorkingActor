<header class="site-header" id="site-header">
	<a class="brand navbar-item" href="<?php echo site_url(); ?>">
		<?php
		$logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
		if (has_custom_logo()) : echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
		else : echo '<span class="subtitle">' . get_bloginfo('name') . '</span>';
		endif;
		?>
	</a>

	<button class="mobile-nav-toggle hamburger hamburger--slider" type="button" aria-label="Menu" aria-expanded="false" aria-controls="site-navigation">
		<span class="hamburger-box">
			<span class="hamburger-inner"></span>
		</span>
		<span class="visually-hidden">Menu</span>
	</button>
	<div id="site-navigation" class="site-navigation">

		<!-- <nav class="navbar-menu"> -->
		<?php

		
		wp_nav_menu(
			array(
				'menu' => byniko\get_correct_nav_menu(),
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'menu_class' 	=> "primary-menu nav-menu",
				'container' 		=> 'nav',
				'container_class' 	=> 'navbar-menu',
				'container_id' 	=> '',
			)
		);
		wp_nav_menu(
			array(
				'theme_location' => 'menu-2',
				'menu_id'        => 'secondary-menu',
				'menu_class' 	=> "secondary-menu nav-menu",
			'container' 		=> 'nav',
				'container_class' 	=> 'navbar-menu',
				'container_id' 	=> '',
			)
		);
		?>
		<!-- </nav> -->
	</div>
</header>
