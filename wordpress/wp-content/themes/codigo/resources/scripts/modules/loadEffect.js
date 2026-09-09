import consoleHello from './consoleHello';
import getCookie from './getCookie';
import gsap from "gsap";


function remToPx(rem) {
  return rem * parseFloat(getComputedStyle(document.documentElement).fontSize);
}

function getOffsetFromCenterToTarget(topRem, leftRem) {
  const targetTop = remToPx(topRem);
  const targetLeft = remToPx(leftRem);

  const centerY = window.innerHeight / 2;
  const centerX = window.innerWidth / 2;

  const offsetY = targetTop - centerY;
  const offsetX = targetLeft - centerX;

  return { x: offsetX, y: offsetY };
}

function getOffsetFromCenterToBottomRight(bottomRem, rightRem) {
  const bottom = remToPx(bottomRem);
  const right = remToPx(rightRem);

  const targetTop = window.innerHeight - bottom;
  const targetLeft = window.innerWidth - right;

  const centerY = window.innerHeight / 2;
  const centerX = window.innerWidth / 2;

  const offsetY = targetTop - centerY;
  const offsetX = targetLeft - centerX;

  return { x: offsetX, y: offsetY };
}



function posterizeTween(target, vars) {
  const steps = 20; // frames per second (choppiness)
  let tween = gsap.to(target, {
    ...vars,
    duration: vars.duration || 1.5,
    ease: vars.ease || "power3.inOut",
    paused: true
  });

  // Step the progress
  gsap.to(tween, {
    progress: 1,
    duration: tween.duration(),
    ease: "linear",
    modifiers: {
      progress: value => {
        let step = 1 / steps;
        return Math.floor(value / step) * step;
      }
    }
  });
}


const loadEffect = () => {

  var headerFinalPosition = [1.25, 1.25];  // 1.25rem top, 1.25rem left
  var footerFinalPosition = [1.35, 1.25]; // bottom: 1.35rem;  right: 1.25rem;
  var startAnimation = 1500;

  if(window.innerWidth >= 768){
    headerFinalPosition = [1.25, 2];  // 1.25rem top, 2rem left
    footerFinalPosition= [1.75, 2];  // bottom: 1.75rem;  right: 2rem;
    startAnimation = 3000;
  }
  if(window.innerWidth >= 1792){
    headerFinalPosition = [1.25, 3.5]; // 1.25rem top, 3.5rem left
    footerFinalPosition= [1.75, 3.5]; // bottom: 1.75rem;  right: 3rem;
  }

  var startButtonsAnimation = startAnimation + 400;
  var startCollaboratorsAnimation = startButtonsAnimation + 300;
  var startImagesAnimation = startCollaboratorsAnimation + 1200;

  const launchPreloader = () => {

    if(!body.classList.contains('load-effect')) return; // Exit if no load-effect class

    const headerLogos = document.querySelectorAll('body.load-effect .splash-logo--header');
    if(!headerLogos) return;
    const footerLogos = document.querySelectorAll('body.load-effect .splash-logo--footer');
    if(!footerLogos) return;

    headerLogos.forEach((headerLogo, headerLogoIndex) => {
      headerLogo.classList.add('splash-logo');

      setTimeout(() => {
        const headerLogo = document.querySelectorAll('.splash-logo--header')[headerLogoIndex];
        headerLogo.classList.add('visible');
      }, 300); // start after slight pause
      setTimeout(() => {
        const headerLogo = document.querySelectorAll('.splash-logo--header')[headerLogoIndex];
        //headerLogo.classList.add('animate-out');
        const { x, y } = getOffsetFromCenterToTarget(
          headerFinalPosition[0],
          headerFinalPosition[1]
        );
        posterizeTween(headerLogo, {
          x: x,
          y: y,
          scale: 1,
          duration: 1.5,
        });
      }, startAnimation);
      setTimeout(() => {
        const headerLogo = document.querySelectorAll('.splash-logo--header')[headerLogoIndex];
        //headerLogo.classList.remove('splash-logo');
        headerLogo.remove();
      }, startAnimation + 2000);
    });

    footerLogos.forEach((footerLogo, footerLogoIndex) => {
      footerLogo.classList.add('splash-logo');
      var footerLogo = document.querySelectorAll('.splash-logo--footer')[footerLogoIndex];
      setTimeout(() => {
        footerLogo.classList.add('visible');
      }, 300); // start after slight pause
      setTimeout(() => {
        //footerLogo.classList.add('animate-out');
        const { x, y } = getOffsetFromCenterToBottomRight(
          footerFinalPosition[0],
          footerFinalPosition[1]
        );
        posterizeTween(footerLogo, {
          x: x,
          y: y,
          scale: 1,
          duration: 1.5,
        });

      }, startAnimation);
      setTimeout(() => {
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

    setTimeout(() => {
      /*
      const footerButtons = document.querySelectorAll('footer.footer .growing-button');
      // add header  .growing-button to buttons
      const headerButtons = document.querySelectorAll('header#mainMenu .growing-button');

      const buttons = [...footerButtons, ...headerButtons];
      */

      const buttons = document.querySelectorAll('.growing-button');

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

    setTimeout(() => {
      const elements = document.querySelectorAll(".collaborator-fade-in-up");
      elements.forEach((el, i) => {
        setTimeout(() => {
          el.classList.add("visible");
        }, i * 400); // 400ms delay between each
      });
    }, startCollaboratorsAnimation);

    if(window.innerWidth < 768){ //Advance the image effect on mobile
      setTimeout(() => {
        const elements1 = document.querySelectorAll("figure.collaborator-fade-in-up");
        const elements2 = document.querySelectorAll("a.collaborator-link.collaborator-fade-in-up");
        //merge elements and elements2
        const allElements = [...elements1, ...elements2];
        allElements.forEach((el, i) => {
          setTimeout(() => {
            el.classList.add("visible");
          }, i * 400); // 400ms delay between each
        });
      }, startImagesAnimation);
    }
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

      //consoleHello(document.cookie);  // 'Wed, 21 Apr 2021 17:42:22 GMT'
      body.classList.add('load-effect');
      launchPreloader();

  } else {
    body.classList.remove('load-effect');
    body.classList.add('no-before');
    body.style.opacity = 1;
  }

  //Debug
  //body.classList.add('load-effect');
  //launchPreloader();
};

export default loadEffect;
