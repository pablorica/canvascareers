const salaries = () => {


  function closeAllSalaries(
    index = null,
    list
  ) {
    const accordions = Array.from(list.getElementsByClassName('salary-accordion'));
    const totalItems = accordions.length;

    // Reset all items
    accordions.forEach((accordion) => {
      const parent = accordion.parentNode;
      parent.classList.remove('visible', 'opened');
    });



    // Collapse all except the selected one
    accordions.forEach((accordion, i) => {
      if (index !== null && i === index) return;

      const parent = accordion.parentNode;
      const content = parent.querySelector(`#collapse-${i}`);
      const icon = parent.querySelector(`.icon-${i}`);
      const applyButton = parent.querySelector('.toggle-form');
      const formContainer = parent.querySelector('.form-container');

      //Check if content exists
      if (!content) {
        return;
      }

      content.style.maxHeight = '0';
      content.classList.add('overflow-hidden');
      content.classList.remove('overflow-y-scroll');
      icon.style.transform = 'rotate(0deg)';

      if (applyButton && !formContainer.classList.contains('hidden')) {
        formContainer.classList.add('hidden');
        applyButton.classList.remove('active');
      }
    });
  }

  // Accordions
  function toggleAccordion(element, index, list) {
    const currentWidth = window.innerWidth;
    const parent       = element.parentNode;

    const content       = parent.querySelector(`#collapse-${index}`);
    const icon          = parent.querySelector(`.icon-${index}`);


    // Hide all other accordions
    closeAllSalaries(index, list);

    parent.classList.remove('opened');

    //Check if content exists
    if (!content) {
      console.warn(`No content found for accordion index ${index}`);
      return;
    }

    console.warn(`content.style.maxHeight: ${content.style.maxHeight}`);

    // Toggle the content's max-height for smooth opening and closing
    if (content.style.maxHeight && content.style.maxHeight !== '0px') {

      // Hide the content
      content.style.maxHeight = '0';
      content.classList.add('overflow-hidden');
      content.classList.remove('overflow-y-scroll');

      // Reset the icon rotation
      icon.style.transform = 'rotate(0deg)';

    } else {

      parent.classList.add('opened');
      content.style.maxHeight = content.scrollHeight   + 'px';
      icon.style.transform = 'rotateX(180deg)';
    }
  }

  const salaryLists = document.querySelectorAll('.salary-list');

  if (salaryLists.length > 0) {

    Array.from(salaryLists).forEach((list, lndex) => {

      const accordions = list.getElementsByClassName('salary-accordion');

      if (accordions.length > 0) {
        Array.from(accordions).forEach((accordion, index) => {
          accordion.addEventListener('click', () => toggleAccordion(accordion, index, list));
        });
      }

    });


  }
}

export default salaries;
