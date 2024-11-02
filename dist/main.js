/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scripts/accordion.js":
/*!**********************************!*\
  !*** ./src/scripts/accordion.js ***!
  \**********************************/
/***/ (() => {

const accordionContent = document.querySelectorAll(".accordion");
accordionContent.forEach((item, index) => {
  let header = item.querySelector(".accordion-trigger");
  let description = item.querySelector(".accordion-content");
  header.addEventListener("click", () => {
    item.classList.toggle("is-open");
    if (item.classList.contains("is-open")) {
      // Scrollheight property return the height of
      // an element including padding
      description.style.height = `${description.scrollHeight}px`;
      // item.querySelector("i").classList.replace("fa-plus","fa-minus");
    } else {
      description.style.height = "0px";
      // item.querySelector("i").classList.replace("fa-minus","fa-plus");
    }
    // function to pass the index number of clicked header
    // removeOpenedContent( index );
  });
});
function removeOpenedContent(index) {
  accordionContent.forEach((item2, index2) => {
    if (index != index2) {
      item2.classList.remove("is-open");
      let descrip = item2.querySelector(".accordion-content");
      descrip.style.height = "0px";
      // item2.querySelector("i").classList.replace("fa-minus","fa-plus");
    }
  });
}

/***/ }),

/***/ "./src/scripts/main.js":
/*!*****************************!*\
  !*** ./src/scripts/main.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _navigation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./navigation */ "./src/scripts/navigation.js");
/* harmony import */ var _navigation__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_navigation__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _accordion__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./accordion */ "./src/scripts/accordion.js");
/* harmony import */ var _accordion__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_accordion__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _vimeo_video__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./vimeo-video */ "./src/scripts/vimeo-video.js");




/***/ }),

/***/ "./src/scripts/micromodal.js":
/*!***********************************!*\
  !*** ./src/scripts/micromodal.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var micromodal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! micromodal */ "./node_modules/micromodal/dist/micromodal.es.js");
/* harmony import */ var _vimeo_video_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./vimeo-video.js */ "./src/scripts/vimeo-video.js");


micromodal__WEBPACK_IMPORTED_MODULE_0__["default"].init({
  onShow: async (modal, el, triggerEv) => {
    closeAllOthers(modal);
    bodyScrollbar();
    autoIframeVimeo(modal, el, triggerEv);
    autoIframeModal(modal, el, triggerEv);
  },
  // [1]
  onClose: modal => {
    // modal.querySelector( '.modal__container' ).classList.remove( 'is-ready' );
    const iframe = modal.querySelector('iframe');
    if (iframe) {
      iframe.remove();
    }
    bodyScrollbar();
  },
  // [2]
  // openTrigger: 'data-custom-open', // [3]
  // closeTrigger: 'data-custom-close', // [4]
  openClass: 'is-open',
  // [5]
  disableScroll: true,
  // [6]
  disableFocus: false,
  // [7]
  awaitOpenAnimation: false,
  // [8]
  awaitCloseAnimation: false,
  // [9]
  debugMode: true // [10]
});
function bodyScrollbar() {
  document.body.classList.toggle('modal-open');
}
async function autoIframeVimeo(modal, el, triggerEv) {
  const videoTrigger = triggerEv.target.closest('[data-video-url]');
  let videoUrl = videoTrigger && videoTrigger.getAttribute('data-video-url');
  if (videoUrl && videoUrl.length) {
    el.classList.add('is-iframe-container');

    // videoUrl = isValidCanvaUrl( videoUrl );

    const isVimeo = await (0,_vimeo_video_js__WEBPACK_IMPORTED_MODULE_1__.isValidVimeoUrl)(videoUrl);
    const iframe = document.createElement('iframe');
    const container = modal.querySelector('.modal__container');
    const main = modal.querySelector('main');
    iframe.onload = function () {
      console.log('iframe loaded');
      container.classList.add('is-ready');
    };
    if (isVimeo) {
      iframe.setAttribute('allow', 'autoplay');
      iframe.classList.add('responsive_embed');
      iframe.setAttribute('style', `width: 100%; aspect-ratio:${isVimeo.width || 16}/${isVimeo.height || 9}`);
      iframe.src = `https://player.vimeo.com/video/${isVimeo.video_id}?badge=0&vimeo_logo=false&title=false&autoplay=1&byline=false&responsive=true`;
      // iframe.src = `https://www.canva.com/design/DAGIoM35H1w/fumRJ552w3BTDbIdlSle9w/watch?embed`;
      // iframe.src = `https://www.canva.com/design/DAGIPuaZxqg/FHEixGSbK7vev6ZjdNBI0Q/watch?embed`;
      main.append(iframe);
      // container.classList.add( 'is-ready' );
    }
  }
}
async function autoIframeModal(modal) {
  const iframeUrl = modal.getAttribute('data-iframe-url');
  if (iframeUrl && iframeUrl.length) {
    const iframe = document.createElement('iframe');
    const container = modal.querySelector('.modal__container');
    const content = modal.querySelector('.modal__content');
    iframe.onload = function () {
      // container.classList.add( 'is-ready' );
    };
    iframe.setAttribute('style', `width:100%;height:100%;border:hidden;`);
    iframe.src = iframeUrl;
    content.append(iframe);
    container.classList.add('is-ready');
  }
}
function isValidCanvaUrl(url) {
  const isCanva = url.match(/canva/) !== null;
  const isCanvaURL = isCanva && new URL(url);
  isCanvaURL.searchParams.set('embed', '');

  // add the embed parameter to canva urls
  return isCanva ? isCanvaURL.href : false;
}
function closeAllOthers(modal) {
  document.querySelectorAll('.modal.is-open').forEach(isOpen => {
    if (modal !== isOpen) {
      micromodal__WEBPACK_IMPORTED_MODULE_0__["default"].close(isOpen.id);
    }
  });
}

/***/ }),

/***/ "./src/scripts/navigation.js":
/*!***********************************!*\
  !*** ./src/scripts/navigation.js ***!
  \***********************************/
/***/ (() => {

/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
  const state = {
    isActive: false
  };
  const siteNavigation = document.getElementById('site-navigation');
  // Return early if the navigation doesn't exist.
  if (!siteNavigation) {
    return;
  }
  const button = document.querySelector('.mobile-nav-toggle');

  // Return early if the button doesn't exist.
  if ('undefined' === typeof button) {
    return;
  }
  const menus = siteNavigation.getElementsByTagName('ul');

  // Hide menu toggle button if menu is empty and return early.
  // if ( 'undefined' === typeof menu ) {
  // 	button.style.display = 'none';
  // 	return;
  // }

  for (let i = 0; i < menus.length; i++) {
    const menu = menus[i];
    if (!menu.classList.contains('nav-menu')) {
      menu.classList.add('nav-menu');
    }
  }

  // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
  button.addEventListener('click', function () {
    state.isActive = !state.isActive;
    siteNavigation.classList.toggle('is-active');
    button.classList.toggle('is-active');
    if (button.getAttribute('aria-expanded') === 'true') {
      button.setAttribute('aria-expanded', 'false');
    } else {
      button.setAttribute('aria-expanded', 'true');
    }
  });
  function closeMobileNav() {
    state.isActive = false;
    siteNavigation.classList.remove('is-active');
    button.classList.remove('is-active');
    button.setAttribute('aria-expanded', 'false');
  }

  // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
  document.addEventListener('click', function (event) {
    const isClickInside = siteNavigation.contains(event.target);
    if (!isClickInside && state.isActive && !button.contains(event.target)) {
      closeMobileNav();
    }
  });

  // Get all the link elements within the menu.
  const links = siteNavigation.getElementsByTagName('a');

  // Get all the link elements with children within the menu.
  const linksWithChildren = siteNavigation.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

  // Toggle focus each time a menu link is focused or blurred.
  for (const link of links) {
    link.addEventListener('focus', toggleFocus, true);
    link.addEventListener('blur', toggleFocus, true);
  }

  // Toggle focus each time a menu link with children receive a touch event.
  for (const link of linksWithChildren) {
    link.addEventListener('touchstart', toggleFocus, false);
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    if (event.type === 'focus' || event.type === 'blur') {
      let self = this;
      // Move up through the ancestors of the current link until we hit .nav-menu.
      while (!self.classList.contains('nav-menu')) {
        // On li elements toggle the class .focus.
        if ('li' === self.tagName.toLowerCase()) {
          self.classList.toggle('focus');
        }
        self = self.parentNode;
      }
    }
    if (event.type === 'touchstart') {
      const menuItem = this.parentNode;
      event.preventDefault();
      for (const link of menuItem.parentNode.children) {
        if (menuItem !== link) {
          link.classList.remove('focus');
        }
      }
      menuItem.classList.toggle('focus');
    }
  }
})();

/***/ }),

/***/ "./src/scripts/vimeo-video.js":
/*!************************************!*\
  !*** ./src/scripts/vimeo-video.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   isValidVimeoUrl: () => (/* binding */ isValidVimeoUrl)
/* harmony export */ });
async function isValidVimeoUrl(url) {
  const resp = await fetch(`https://vimeo.com/api/oembed.json?url=${url}&width=800`);
  return resp.ok && (await resp.json());
}
const iframe_divs = document.querySelectorAll('[data-iframe-url]');
iframe_divs.forEach(async el => {
  const url = el.getAttribute('data-iframe-url');
  const info = await isValidVimeoUrl(url);
  if (info) {
    console.log(info);
    el.innerHTML = `
		<div class="responsive-media-wrapper has-radius has-shadow " style="--aspect-ratio: ${info.width / info.height}; ">
		<iframe class="responsive-media-item" src="${url}" frameborder="0"  allowfullscreen>
		</iframe>
		<!-- <img clas="responsive-media-item video-thumbnail" src="${info.thumbnail_url_with_play_button}" alt="video" > -->
		</div>`;
  }
});

/***/ }),

/***/ "./node_modules/micromodal/dist/micromodal.es.js":
/*!*******************************************************!*\
  !*** ./node_modules/micromodal/dist/micromodal.es.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function e(e,t){for(var o=0;o<t.length;o++){var n=t[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function t(e){return function(e){if(Array.isArray(e))return o(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return o(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);"Object"===n&&e.constructor&&(n=e.constructor.name);if("Map"===n||"Set"===n)return Array.from(e);if("Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n))return o(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(e,t){(null==t||t>e.length)&&(t=e.length);for(var o=0,n=new Array(t);o<t;o++)n[o]=e[o];return n}var n,i,a,r,s,l=(n=["a[href]","area[href]",'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',"select:not([disabled]):not([aria-hidden])","textarea:not([disabled]):not([aria-hidden])","button:not([disabled]):not([aria-hidden])","iframe","object","embed","[contenteditable]",'[tabindex]:not([tabindex^="-"])'],i=function(){function o(e){var n=e.targetModal,i=e.triggers,a=void 0===i?[]:i,r=e.onShow,s=void 0===r?function(){}:r,l=e.onClose,c=void 0===l?function(){}:l,d=e.openTrigger,u=void 0===d?"data-micromodal-trigger":d,f=e.closeTrigger,h=void 0===f?"data-micromodal-close":f,v=e.openClass,g=void 0===v?"is-open":v,m=e.disableScroll,b=void 0!==m&&m,y=e.disableFocus,p=void 0!==y&&y,w=e.awaitCloseAnimation,E=void 0!==w&&w,k=e.awaitOpenAnimation,M=void 0!==k&&k,A=e.debugMode,C=void 0!==A&&A;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,o),this.modal=document.getElementById(n),this.config={debugMode:C,disableScroll:b,openTrigger:u,closeTrigger:h,openClass:g,onShow:s,onClose:c,awaitCloseAnimation:E,awaitOpenAnimation:M,disableFocus:p},a.length>0&&this.registerTriggers.apply(this,t(a)),this.onClick=this.onClick.bind(this),this.onKeydown=this.onKeydown.bind(this)}var i,a,r;return i=o,(a=[{key:"registerTriggers",value:function(){for(var e=this,t=arguments.length,o=new Array(t),n=0;n<t;n++)o[n]=arguments[n];o.filter(Boolean).forEach((function(t){t.addEventListener("click",(function(t){return e.showModal(t)}))}))}},{key:"showModal",value:function(){var e=this,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null;if(this.activeElement=document.activeElement,this.modal.setAttribute("aria-hidden","false"),this.modal.classList.add(this.config.openClass),this.scrollBehaviour("disable"),this.addEventListeners(),this.config.awaitOpenAnimation){var o=function t(){e.modal.removeEventListener("animationend",t,!1),e.setFocusToFirstNode()};this.modal.addEventListener("animationend",o,!1)}else this.setFocusToFirstNode();this.config.onShow(this.modal,this.activeElement,t)}},{key:"closeModal",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=this.modal;if(this.modal.setAttribute("aria-hidden","true"),this.removeEventListeners(),this.scrollBehaviour("enable"),this.activeElement&&this.activeElement.focus&&this.activeElement.focus(),this.config.onClose(this.modal,this.activeElement,e),this.config.awaitCloseAnimation){var o=this.config.openClass;this.modal.addEventListener("animationend",(function e(){t.classList.remove(o),t.removeEventListener("animationend",e,!1)}),!1)}else t.classList.remove(this.config.openClass)}},{key:"closeModalById",value:function(e){this.modal=document.getElementById(e),this.modal&&this.closeModal()}},{key:"scrollBehaviour",value:function(e){if(this.config.disableScroll){var t=document.querySelector("body");switch(e){case"enable":Object.assign(t.style,{overflow:""});break;case"disable":Object.assign(t.style,{overflow:"hidden"})}}}},{key:"addEventListeners",value:function(){this.modal.addEventListener("touchstart",this.onClick),this.modal.addEventListener("click",this.onClick),document.addEventListener("keydown",this.onKeydown)}},{key:"removeEventListeners",value:function(){this.modal.removeEventListener("touchstart",this.onClick),this.modal.removeEventListener("click",this.onClick),document.removeEventListener("keydown",this.onKeydown)}},{key:"onClick",value:function(e){(e.target.hasAttribute(this.config.closeTrigger)||e.target.parentNode.hasAttribute(this.config.closeTrigger))&&(e.preventDefault(),e.stopPropagation(),this.closeModal(e))}},{key:"onKeydown",value:function(e){27===e.keyCode&&this.closeModal(e),9===e.keyCode&&this.retainFocus(e)}},{key:"getFocusableNodes",value:function(){var e=this.modal.querySelectorAll(n);return Array.apply(void 0,t(e))}},{key:"setFocusToFirstNode",value:function(){var e=this;if(!this.config.disableFocus){var t=this.getFocusableNodes();if(0!==t.length){var o=t.filter((function(t){return!t.hasAttribute(e.config.closeTrigger)}));o.length>0&&o[0].focus(),0===o.length&&t[0].focus()}}}},{key:"retainFocus",value:function(e){var t=this.getFocusableNodes();if(0!==t.length)if(t=t.filter((function(e){return null!==e.offsetParent})),this.modal.contains(document.activeElement)){var o=t.indexOf(document.activeElement);e.shiftKey&&0===o&&(t[t.length-1].focus(),e.preventDefault()),!e.shiftKey&&t.length>0&&o===t.length-1&&(t[0].focus(),e.preventDefault())}else t[0].focus()}}])&&e(i.prototype,a),r&&e(i,r),o}(),a=null,r=function(e){if(!document.getElementById(e))return console.warn("MicroModal: ❗Seems like you have missed %c'".concat(e,"'"),"background-color: #f8f9fa;color: #50596c;font-weight: bold;","ID somewhere in your code. Refer example below to resolve it."),console.warn("%cExample:","background-color: #f8f9fa;color: #50596c;font-weight: bold;",'<div class="modal" id="'.concat(e,'"></div>')),!1},s=function(e,t){if(function(e){e.length<=0&&(console.warn("MicroModal: ❗Please specify at least one %c'micromodal-trigger'","background-color: #f8f9fa;color: #50596c;font-weight: bold;","data attribute."),console.warn("%cExample:","background-color: #f8f9fa;color: #50596c;font-weight: bold;",'<a href="#" data-micromodal-trigger="my-modal"></a>'))}(e),!t)return!0;for(var o in t)r(o);return!0},{init:function(e){var o=Object.assign({},{openTrigger:"data-micromodal-trigger"},e),n=t(document.querySelectorAll("[".concat(o.openTrigger,"]"))),r=function(e,t){var o=[];return e.forEach((function(e){var n=e.attributes[t].value;void 0===o[n]&&(o[n]=[]),o[n].push(e)})),o}(n,o.openTrigger);if(!0!==o.debugMode||!1!==s(n,r))for(var l in r){var c=r[l];o.targetModal=l,o.triggers=t(c),a=new i(o)}},show:function(e,t){var o=t||{};o.targetModal=e,!0===o.debugMode&&!1===r(e)||(a&&a.removeEventListeners(),(a=new i(o)).showModal())},close:function(e){e?a.closeModalById(e):a.closeModal()}});"undefined"!=typeof window&&(window.MicroModal=l);/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (l);


/***/ }),

/***/ "./src/scss/index.scss":
/*!*****************************!*\
  !*** ./src/scss/index.scss ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scss/index.scss */ "./src/scss/index.scss");
/* harmony import */ var _scripts_main__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scripts/main */ "./src/scripts/main.js");
/* harmony import */ var _scripts_micromodal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./scripts/micromodal */ "./src/scripts/micromodal.js");
// import main stylesheet


// start scripts


// import './scripts/coursesScripts';
})();

/******/ })()
;
//# sourceMappingURL=main.js.map