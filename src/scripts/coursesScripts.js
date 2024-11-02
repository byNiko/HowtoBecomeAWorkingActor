( () => {
	const lessonsEndpoint = '/wp-json/wp/v2/pmpro_lesson';
	const courseEndpoint = '/wp-json/wp/v2/pmpro_course';
	const contentArea = document.querySelector( '.course-description .content' );
	const lessonsList = document.querySelector( '.inner-lessons-list' );

	lessonsList.addEventListener( 'click', getLessonData );

	async function isValidVimeoUrl( url ) {
		const resp = await fetch( `https://vimeo.com/api/oembed.json?url=${ url }` );
			return resp.ok && await resp.json();
	}

	async function makeIframe( url ) {
		const video_info = await isValidVimeoUrl( url );
		const iframe = document.createElement( 'iframe' );
		
		if ( video_info ) {
			
			// console.log( 'video_info', video_info );
			iframe.src = `https://player.vimeo.com/video/${video_info.video_id}?app_id=122963`
			iframe.classList.add( 'responsive-media-item' );
			return `
		<div class='responsive-media-wrapper has-radius' style='--aspect-ratio:${video_info.width}/${video_info.height};'>
			${iframe.outerHTML}
		</div>
		`;
		}
		
	}


	async function getLessonData( e ) {
		const btn = e.target.closest( '.lesson-item-wrap' );
		if ( btn ) {
			e.preventDefault();
			const lessonId = btn.dataset.lessonId;
			// fetch data from lessonId
			const res = await fetch( lessonsEndpoint + '/' + lessonId )
			const data = await res.json()
			const video_lesson_url = data.acf.lesson_video_url;
			// console.log(video_lesson_url);
			const iframe = await makeIframe(video_lesson_url);
			contentArea.innerHTML = iframe + data.content.rendered;
		}
	}

} )()