
export async function isValidVimeoUrl( url ) {
	const resp = await fetch( `https://vimeo.com/api/oembed.json?url=${ url }&width=800` );
		return resp.ok && await resp.json();
}


export async function  getVimeoPlayer( url, videoInfo)  {
	let info = videoInfo || await isValidVimeoUrl( url );
	console.log(info);
	const iframeSrc = `https://player.vimeo.com/video/${info.video_id}?badge=0&vimeo_logo=false&title=false&byline=false&responsive=true`
	return `<div class="responsive-media-wrapper has-radius has-shadow " style="--aspect-ratio: ${info.width / info.height}; ">
	<iframe  loading="lazy" class="responsive-media-item" src="${iframeSrc}" frameborder="0"  allowfullscreen>
	</iframe>

	</div>`;
}


const iframe_divs = document.querySelectorAll( '[data-iframe-url]' );
iframe_divs.forEach( async (el) => {
	const url = el.getAttribute( 'data-iframe-url' );
	const info = await isValidVimeoUrl( url );
	if ( info ) {
		el.innerHTML = await getVimeoPlayer( url, info );
	}
} )
