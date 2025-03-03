// Get the button:
let backToTop = document.getElementById( "back-to-top-button" );

backToTop.addEventListener( "click", topFunction );
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 350 || document.documentElement.scrollTop > 350) {
	//   backToTop.style.display = "block";
	  backToTop.classList.add("active");
  } else {
	backToTop.classList.remove("active");
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}