<?php

// autoload classes
spl_autoload_register(function ($class_name) {
	get_template_part("/inc/classes/$class_name");
});

require __DIR__ . '/Byniko.php';

#use byniko;