// https://github.com/ganlanyuan/tiny-slider'
import {tns} from 'tiny-slider/src/tiny-slider.js';

const tinyslider = () => {

  function listOfCarousels(wrapperCarousels) {
    Array.from(wrapperCarousels).forEach((wrapperCarousel) => {
      const carousel = wrapperCarousel.querySelector('.tiny-carousel');

      let carAutoplay = false;
      if (carousel.dataset.autoplay) {
        carAutoplay = carousel.dataset.autoplay;
      }

      //console.log('carAutoplay', carAutoplay);

      let carNavigation = false;
      if (carousel.dataset.navigation) {
        carNavigation = carousel.dataset.navigation;
      }

      let carMode = 'carousel'; //"carousel" | "gallery"
      if (carousel.dataset.transition) {
        carMode = carousel.dataset.transition;
      }

      let autoplayTimeout = 3500;
      if (carousel.dataset.autoplayTimeout) {
        autoplayTimeout = carousel.dataset.autoplayTimeout;
      }

      let responsiveItems = {
        0: {
          items: 1,
        },
        768: {
          items: 2,
        },
        1280: {
          items: 3,
        },
        1480: {
          items: 4,
        },
      };
      if (carousel.dataset.responsiveItems) {
        responsiveItems = JSON.parse(carousel.dataset.responsiveItems);
      }

      let mouseDrag = false;
      if (carousel.dataset.mouseDrag) {
        mouseDrag = carousel.dataset.mouseDrag;
      }

      let slider = tns({
        container: carousel,
        items: 1,
        responsive: responsiveItems,
        mode: carMode,
        autoplay: carAutoplay,
        controls: false,
        nav: carNavigation,
        navPosition: 'bottom',
        // autoplay: true in combination with mouseDrag: true results in weird behavior after dragging, see also: https://github.com/ganlanyuan/tiny-slider/issues/521
        mouseDrag: mouseDrag,
        autoplayButtonOutput: false,
        swipeAngle: false,
        autoplayHoverPause: true,
        speed: 1500,
        autoplayTimeout: autoplayTimeout,
        loop: true,
      });

      let nextButton = null;
      let prevButton = null;
      if (wrapperCarousel.querySelector('.next-button')) {
        nextButton = wrapperCarousel.querySelector('.next-button');
        prevButton = wrapperCarousel.querySelector('.prev-button');
      }

      if (nextButton) {
        nextButton.onclick = function () {
          slider.goTo('next');
        };
      }
      if (prevButton) {
        prevButton.onclick = function () {
          slider.goTo('prev');
        };
      }
    });
    return null;
  }

  const wrapperCarousels = document.getElementsByClassName('wrapper-carousel');

  if (wrapperCarousels.length > 0) {
    const cssId = 'tinyCss';  // Load Css only once.
    if (!document.getElementById(cssId)) {
      const head = document.getElementsByTagName('head')[0];
      const link = document.createElement('link');
      link.id = cssId;
      link.rel = 'stylesheet';
      link.type = 'text/css';
      link.href = 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css';
      link.media = 'all';
      head.appendChild(link);
    }

    if (wrapperCarousels.length > 0) {
      listOfCarousels(wrapperCarousels);
    }
  }
}

export default tinyslider;
