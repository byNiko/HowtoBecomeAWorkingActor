const els = document.querySelectorAll( '[data-equal-height]' );
if ( els.length ) {

	els.forEach( el => {
		const targetClass = el.getAttribute( 'data-equal-height' );
		const target = el.parentElement.querySelector(`.${targetClass}`);
		const elHeight  =  target.offsetHeight ;
	el.style.height = `${elHeight}px`;
  } );
}