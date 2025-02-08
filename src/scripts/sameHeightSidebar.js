import {debounce} from "./utilities.js";

const equalizeHeight = debounce( makeEqualHeight );
window.addEventListener( "load", makeEqualHeight );

window.addEventListener( "resize", equalizeHeight );


function makeEqualHeight() {
	const els = document.querySelectorAll( '[data-equal-height-target]' );
	if ( els.length ) {
		els.forEach( el => {
			const targetSelector = el.getAttribute( 'data-equal-height-target' );
			const target = el.parentElement.querySelector( `${targetSelector}` );
			const elHeight = target.offsetHeight;
			el.style.height = `${elHeight}px`;
		} );
	}
}
