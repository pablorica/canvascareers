const loadEffect = () => {
  const buttons = document.querySelectorAll('.button-menu');
  const typingDelayBetweenButtons = 300; // Delay between starting each button (ms)

  buttons.forEach((button, btnIndex) => {
    const fullText = button.getAttribute('data-title');
    let index = 0;

    button.textContent = "";
    button.classList.add('loading');
    button.style.opacity = 0;

    // Delay each button's animation based on its index
    setTimeout(() => {
      function typeLetter() {
        if (index <= fullText.length) {
          button.textContent = fullText.substring(0, index);
          button.style.opacity = index / fullText.length;
          index++;
          setTimeout(typeLetter, 50);
        } else {
          button.classList.remove('loading');
          button.classList.add('loaded');
          button.style.opacity = 1;
          index = 0;
        }
      }

      typeLetter(); // Start typing after delay
    }, btnIndex * typingDelayBetweenButtons);


    setTimeout(() => {
      const elements = document.querySelectorAll(".collaborator-fade-in-up");
      elements.forEach((el, i) => {
        setTimeout(() => {
          el.classList.add("visible");
        }, i * 400); // 400ms delay between each
      });
    }, 2000);


  });
};

export default loadEffect;
