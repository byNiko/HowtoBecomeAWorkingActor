<?php


/* This PHP class named Modal is likely used to create and manage modal windows for displaying content
on a web page. */
class Modal {
	public $args= array();
	public $modal;
	public $trigger;
	public $id, $content, $title, $trigger_cta, $trigger_class;
	
	
	/**
	 * Undocumented function
	 *
	 * @param  array $args
	 */
	 function __construct(array $args = array()) {
		$defaults = array(
			'id' => uniqid(),
			'content' => '',
			'title' => '',
			'trigger_cta' => "Open Modal",
			'trigger_class' => 'button secondary',
		);
		$this->args = wp_parse_args($args, $defaults);
		$this->args = $defaults;
		$this->modal = $this->makeModal();
		$this->trigger = $this->get_trigger();
	}

	private function get_trigger() {
		
		extract($this->args);
		// var_dump($id);
		return "<button class='$trigger_class' data-micromodal-trigger='modal-$id'>$trigger_cta</button>";
	}
	private function makeModal() {
		extract($this->args);

		$modal_id = 'modal-' . $id;
		

		return "<div class='modal micromodal-slide' id='$modal_id' aria-hidden='true'>
		<div class='modal__overlay' tabindex='-1' data-micromodal-close>
			<div class='modal__container' role='dialog' aria-modal='true' aria-labelledby='$modal_id-title'>
				<header class='modal__header'>
					<h2 class='modal__title' id='$modal_id-title'>
					$title
					</h2>
					<button class='modal__close' aria-label='Close modal' data-micromodal-close></button>
				</header>
				<main class='modal__content' id='$modal_id-content'>
					$content
				</main>
				<!-- <footer class='modal__footer'>
					<button class='modal__btn modal__btn-primary'>Continue</button>
					<button class='modal__btn' data-micromodal-close aria-label='Close this dialog window'>Close</button>
				</footer> -->
			</div>
		</div>
	</div>";
	}
}
