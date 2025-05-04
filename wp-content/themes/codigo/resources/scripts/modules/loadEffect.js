import consoleHello from './consoleHello';
import getCookie from './getCookie';

const loadEffect = () => {

  //Check window width
  if(window.innerWidth < 768){
    return; // Exit if mobile
  }

  const launchPreloader = () => {

    if(!body.classList.contains('load-effect')) return; // Exit if no load-effect class

    const headerLogos = document.querySelectorAll('body.load-effect .splash-logo--header');
    if(!headerLogos) return;
    const footerLogos = document.querySelectorAll('body.load-effect .splash-logo--footer');
    if(!footerLogos) return;

    const startAnimation = 3000;

    headerLogos.forEach((headerLogo, headerLogoIndex) => {
      headerLogo.classList.add('splash-logo');
      setTimeout(() => {
        const headerLogo = document.querySelectorAll('.splash-logo--header')[headerLogoIndex];
        headerLogo.classList.add('visible');

      }, 300); // start after slight pause
      setTimeout(() => {
        const headerLogo = document.querySelectorAll('.splash-logo--header')[headerLogoIndex];
        headerLogo.classList.add('animate-out');

      }, startAnimation);
      setTimeout(() => {
        const headerLogo = document.querySelectorAll('.splash-logo--header')[headerLogoIndex];
        //headerLogo.classList.remove('splash-logo');
        headerLogo.remove();

      }, startAnimation + 2000);
    });

    footerLogos.forEach((footerLogo, footerLogoIndex) => {
      footerLogo.classList.add('splash-logo');
      setTimeout(() => {
        const footerLogo = document.querySelectorAll('.splash-logo--footer')[footerLogoIndex];
        footerLogo.classList.add('visible');

      }, 300); // start after slight pause
      setTimeout(() => {
        const footerLogo = document.querySelectorAll('.splash-logo--footer')[footerLogoIndex];
        footerLogo.classList.add('animate-out');

      }, startAnimation);
      setTimeout(() => {
        const footerLogo = document.querySelectorAll('.splash-logo--footer')[footerLogoIndex];
        //footerLogo.classList.remove('splash-logo');
        footerLogo.remove();

      }, startAnimation + 2000);
    });

    setTimeout(() => {
      //remove body pseudoclass before
      body.classList.add('no-before');
    }, startAnimation + 1000);


    const footer = document.querySelector('footer.footer');
    if(!footer) return; // Exit if no footer found
    footer.classList.add('animated-footer');
    setTimeout(() => {
      footer.classList.add('border-grow');
    }, startAnimation+ 800);
    setTimeout(() => {
      footer.classList.remove('animated-footer');
    }, startAnimation+ 1800);


    const startButtonsAnimation = startAnimation + 400;
    setTimeout(() => {
      const footerButtons = document.querySelectorAll('footer.footer .growing-button');
      // add header  .growing-button to buttons
      const headerButtons = document.querySelectorAll('header#mainMenu .growing-button');

      const buttons = [...footerButtons, ...headerButtons];

      const typingDelayBetweenButtons = 300; // Delay between starting each button (ms)
      if(!buttons.length) return; // Exit if no buttons found
      //console.log('buttons.length: ', buttons.length);
      buttons.forEach((button, btnIndex) => {
        const fullText = button.getAttribute('data-title');

        //console.log('button: ', fullText);
        let index = 0;

        button.textContent = "";
        button.classList.add('loading');
        button.style.opacity = 0;

        // Delay each button's animation based on its index
        setTimeout(() => {

          /*
          * This line is really important, we need to get again the button element,
          * becasue for some reason the buttons in the header get lost in the DOM
          * (probably there is another JS affecting them)
          *
          * By re-selecting the DOM element inside setTimeout, you avoid the
          * issue of stale references, which was clearly caused by another
          * script (possibly a header animation, lazy loader, or page transition
          * system) removing or replacing the original buttons after your script started.
          *
          * This line guarantees you're always working with the current,
          * live DOM — not a possibly outdated reference.
          *
          *
          */
          const freshButton = document.querySelectorAll('.growing-button')[btnIndex];


          function typeLetter() {
            if (index <= fullText.length) {
              freshButton.textContent = fullText.substring(0, index);
              freshButton.style.opacity = index / fullText.length;
              index++;
              setTimeout(typeLetter, 50);
            } else {

              freshButton.classList.remove('loading');
              freshButton.classList.add('loaded');
              freshButton.style.opacity = 1;
              //index = 0;
            }
          }

          typeLetter(); // Start typing after delay
        }, btnIndex * typingDelayBetweenButtons);

      });
    }, startButtonsAnimation);

    const startCollaboratorsAnimation = startButtonsAnimation + 300;
    setTimeout(() => {
      const elements = document.querySelectorAll(".collaborator-fade-in-up");
      elements.forEach((el, i) => {
        setTimeout(() => {
          el.classList.add("visible");
        }, i * 400); // 400ms delay between each
      });
    }, startCollaboratorsAnimation);
  }

  var body = document.querySelector('body');
  var preloaderCookie = getCookie('preloadershowed');
  //var preloaderCookie = null;
  var createCookie = false;

  if( preloaderCookie === null ) {
      createCookie = true;
  }

  if( createCookie ) {
      /*
      var now = new Date();
      var created = now.toUTCString();
      var time = now.getTime();
      var expireTime = time + 1000*3600*24*30; //One month
      now.setTime(expireTime);
      document.cookie = 'preloadershowed='+created+';expires='+now.toUTCString()+';path=/;SameSite=Strict';
      document.cookie = 'preloadershowed='+created+';expires='+now.toUTCString()+';path=/;SameSite=Strict';
      */

      // Create a session cookie, it does not have an expiration date, the cookie is deleted when the browser is closed
      document.cookie = "preloadershowed=true;path=/;SameSite=Strict";

      consoleHello(document.cookie);  // 'Wed, 21 Apr 2021 17:42:22 GMT'
      body.classList.add('load-effect');
      launchPreloader();

  } else {
    body.classList.remove('load-effect');
    body.classList.add('no-before');
    body.style.opacity = 1;
  }
};

export default loadEffect;
