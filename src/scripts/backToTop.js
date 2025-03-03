import { debounce } from "./utilities.js";
// Get the button:
let backToTop = document.getElementById( "back-to-top-button" );
const totalHeight = document.documentElement.scrollHeight - window.innerHeight;

backToTop.addEventListener( "click", topFunction );
function getScrollPercentage() {
    // Get the scroll position
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    // Calculate the percentage scrolled
    const scrollPercentage = (scrollTop / totalHeight) * 100;

    return scrollPercentage;
}
// When the user clicks on the button, scroll to the top of the document
function topFunction() {
	document.body.scrollTop = 0; // For Safari
	document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
  
function watchScroll() {
	const scrollPercentage = getScrollPercentage();
	if(scrollPercentage > 30){
		backToTop.classList.add("active");
	}else{
		backToTop.classList.remove("active");
	}
}

window.addEventListener('scroll', debounce(watchScroll, 80));