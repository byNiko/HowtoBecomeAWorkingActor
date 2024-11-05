<!doctype html>
<html <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php 
	wp_head(); 
	$default_bg = array(
		'bg_image' =>get_the_post_thumbnail_url( get_option('page_on_front'), 'full'), 
		'bg_overlay' => 'var(--primary-linear-gradient)',
		'bg_position' => 'top',
		'link'=>false,
	);
	$show_hero = byniko\show_hero();
	$bg =$show_hero? byniko\get_hero_background_settings(): $default_bg;
	// var_dump($bg);
	?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site-container">
		<div class="landing container">
			<div class="bg-gradient"></div>
			<div class="row">
			<?php get_template_part('template-parts/header/site-header'); ?>
			<?php // if ( ("pmpro_course" !== get_post_type() ) && ("pmpro_lesson" !== get_post_type())): ?>
				<div class="hero__background"  style="--background: url(<?= $bg['bg_image']; ?>), <?= $bg['bg_overlay'];?>; background-position: <?= $bg['bg_position'];?>;"></div>
			
				<?php //if (is_front_page()): ?>
				<?php //get_template_part('template-parts/hero/hero', 'home'); ?>
				<?php //else: ?>
					<?php if ($show_hero): ?>
					<?php get_template_part('template-parts/hero/hero', null, $bg); ?>
					<?php endif; ?>
				<?php //get_template_part('template-parts/hero/hero', $post->post_name, $bg); ?>
			<?php //endif; ?>
			</div>
		</div>
		<?php //endif; 
		?>
		<section class="page-content">
			<main id="primary" class="site-main">