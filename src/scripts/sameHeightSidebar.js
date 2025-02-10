import { debounce } from "./utilities.js";
import 'overlayscrollbars/overlayscrollbars.css';
import { OverlayScrollbars } from 'overlayscrollbars';



const equalizeHeight = debounce( makeEqualHeight );
window.addEventListener( "load", makeEqualHeight );

window.addEventListener( "resize", equalizeHeight );


function customScrollBar( el ) {
	const innerEl = el.querySelector( '.inner-lessons-list' );
	if ( ! innerEl ) {
		return;
	}
	OverlayScrollbars( {
		target: innerEl,
		scrollbars: {
			slot: innerEl.parentElement,
		},
	}, {
		// options here
	} );
}


function makeEqualHeight() {
	
	const els = document.querySelectorAll( '[data-equal-height-target]' );
	if ( els.length ) {
		els.forEach( el => {
			const targetSelector = el.getAttribute( 'data-equal-height-target' );
			const target = el.parentElement.querySelector( `${targetSelector}` );
			const elHeight = target.offsetHeight;
			el.style.height = `${elHeight}px`;
			customScrollBar( el );
		} );
	}
}
