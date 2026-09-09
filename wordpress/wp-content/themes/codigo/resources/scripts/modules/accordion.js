const accordion = () => {
  function toggleAccordion(element, index) {
    const parent = element.parentNode;

    const content = parent.querySelector(`#collapse-${index}`);
    const topContent = parent.querySelector(`.accordion-before-${index}`);
    const icon = parent.querySelector(`.icon-${index}`);

    // Toggle the content's max-height for smooth opening and closing
    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
      if (topContent) {
        topContent.style.maxHeight = '0';
      }

      content.style.maxHeight = '0';
      icon.style.transform = 'rotate(0deg)';
    } else {
      if (topContent) {
        topContent.style.maxHeight = topContent.scrollHeight + 'px';
      }

      content.style.maxHeight = content.scrollHeight + 'px';
      icon.style.transform = 'rotate(45deg)';
    }
  }

  const accordions = document.getElementsByClassName('button-collapse');

  if (accordions.length > 0) {
    Array.from(accordions).forEach((accordion, index) => {
      accordion.addEventListener('click', () => toggleAccordion(accordion, index));
    });
  }
}

export default accordion;
