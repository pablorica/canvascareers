import domReady from '@roots/sage/client/dom-ready';
import Emitter from 'tiny-emitter';

/**
 * VUE dependencies
 */
import { createApp } from 'vue';
import Example from './vuecomponents/Example.vue';
import MenuCollapse from './vuecomponents/MenuCollapse.js';

export var emitter = new Emitter();

/**
 * Custom modules
 */
import consoleHello from './modules/consoleHello';

/**
 * Application entrypoint
 */
domReady(async () => {
  //consoleHello('DOMContentLoaded')

  /**
   * VUE Components
   */
  if (document.getElementById("vueExample")) {
    const app = createApp(Example);
    app.mount('#vueExample');
  }
  if (document.getElementById("mainMenu")) {
    const app = createApp(MenuCollapse);
    app.mount('#mainMenu');
  }
});

/**
 * Custom Modules
 */
const CDG = {
  onreadyFunctions: function() {
    consoleHello('CDG is ready');

    window.addEventListener("resize", function(){
      //consoleHello('window has resized');
      if(window.innerWidth < 768){
        //consoleHello('narrow');
      }
      else{
        //consoleHello('wide');
      }
    });
  },

  onloadFunctions: function() {
    //consoleHello('CDG is loaded');
  }
};

CDG.onreadyFunctions();

window.onload = function(event) {
  CDG.onloadFunctions();
};

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
if (import.meta.webpackHot) import.meta.webpackHot.accept(console.error);
