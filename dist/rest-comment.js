document.addEventListener( 'DOMContentLoaded', function () {
	const commentForm = document.getElementById( 'commentform' );

	const status = {
		submitting: false
	}
	if ( commentForm && status.submitting === false ) {
		commentForm.addEventListener( 'submit', function ( event ) {
			event.preventDefault();
			status.submitting = true;

			const postId = commentForm.querySelector( '#comment_post_ID' ).value;
			const parentId = commentForm.querySelector( '#comment_parent' ).value;
			// const author = document.querySelector('author').value;
			// const email = document.getElementById('email').value;
			const content = commentForm.querySelector( '#comment' ).value;
			if ( content === '' ) {
				return;
			}
			const data = {
				post: parseInt( postId ),
				parent: parentId,
				// author_name: author,
				// author_email: email,
				content: content,
			};

			showLoader();
			submitComment( data, status );
		} )
	}

	function submitComment( data, status ) {

		fetch( '/wp-json/wp/v2/comments', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': wpApiSettings.nonce,
			},
			body: JSON.stringify( data ),
		} )
			.then( response => {
				if ( !response.ok ) {
					return response.json().then( errorData => {
						throw new Error( JSON.stringify( errorData ) );
					} );
				}
				return response.json();
			} )
			.then( comment => {
				resetRespond( comment );

				// Add code to display comment
			} )
			.finally( () => {
				status.submitting = false;
			} )
			.catch( error => {
				console.error( 'Error submitting comment:', error );
				try {
					const errorObject = JSON.parse( error.message );
					alert( errorObject.message );
				} catch ( e ) {
					alert( 'An unknown error occurred.' );
				}
			} );
	}

	function resetRespond( commentResponse ) {
		const respondEl = document.getElementById( 'loader' );
		const { status, content } = commentResponse;
		// const respondEl = document.getElementById( 'respond' );
		if ( status === 'hold' ) {
			respondEl.insertAdjacentElement( 'afterEnd', getHoldElement( content ) )
		}
		if ( status === 'ok' ) {
			respondEl.insertAdjacentElement( 'afterEnd', getSuccessElement() )
		}
		hideLoader();
	}

	function getHoldElement( content ) {
		const commentHold = document.createElement( 'div' );
		const notice = document.createElement( 'p' );
		notice.classList.add( 'comment-hold-notice' );
		notice.innerText = "Thanks for the comment. Our moderators will review it before it is published";
		commentHold.appendChild( notice );


		commentHold.classList.add( 'comment-hold' );
		const commentText = document.createElement( 'p' );
		commentText.classList.add( 'comment-text' );
		commentText.innerHTML = content.rendered;
		commentHold.appendChild( commentText );
		return commentHold;
	}

	function getSuccessElement() {

		const commentSuccess = document.createElement( 'div' );
		commentSuccess.innerText = "Thanks for the comment. We review all comments before publishing"
		commentSuccess.classList.add( 'comment-success' );
		return commentSuccess;
	}

	function showLoader() {
		const respondEl = document.getElementById( 'respond' );
		const loader = document.createElement( 'div' );
		loader.classList.add( 'loader' );
		loader.id = 'loader';
		loader.innerText = 'Submitting Comment...';
		if ( respondEl ) {
			respondEl.insertAdjacentElement( 'afterEnd', loader )
		}
		document.getElementById( 'comment' ).value = '';
		document.getElementById( 'cancel-comment-reply-link' ).click();

	}
	function hideLoader() {
		const loader = document.getElementById( 'loader' );
		if ( !loader ) {
			return;
		}
		loader.remove();
	}

} );