
export async function isValidVimeoUrl( url ) {
	const resp = await fetch( `https://vimeo.com/api/oembed.json?url=${ url }&width=800` );
		return resp.ok && await resp.json();
}


const iframe_divs = document.querySelectorAll( '[data-iframe-url]' );
iframe_divs.forEach( async (el) => {
	const url = el.getAttribute( 'data-iframe-url' );
	const info = await isValidVimeoUrl( url );
	if ( info ) {
		console.log(info);
		el.innerHTML = `
		<div class="responsive-media-wrapper has-radius has-shadow " style="--aspect-ratio: ${info.width / info.height}; ">
		<iframe class="responsive-media-item" src="${url}" frameborder="0"  allowfullscreen>
		</iframe>
		<!-- <img clas="responsive-media-item video-thumbnail" src="${info.thumbnail_url_with_play_button}" alt="video" > -->
		</div>`;
	}

})