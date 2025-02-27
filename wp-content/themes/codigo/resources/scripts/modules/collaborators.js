const collaborators = () => {
  const years = document.querySelectorAll('#collaborators .collaborators-year');
  if (years.length > 0) {
    years.forEach(year => {
      year.addEventListener('click', function() {
        const filter = this.getAttribute('data-filter');
        const collaborators = document.querySelectorAll('#collaborators .collaborators');
        const collaboratorsYear = document.querySelector(`#collaborators .collaborators-${filter}`);

        // Remove the active class from all years
        years.forEach($year => {
          $year.classList.remove('!bg-charcoal', '!text-chalk');
        });

        this.classList.add('!bg-charcoal', '!text-chalk');

        // Hide all collaborator sliders
        collaborators.forEach(collaborator => {
          collaborator.classList.add('hidden');
        });

        // Show the selected collaborator slider
        collaboratorsYear.classList.remove('hidden');
      });
    });
  }

  // Single collaborators read more
  const content = document.querySelector('.single-collaborator .content');
  if (content) {
    if (content.scrollHeight > 800) {
      content.classList.add('mobile');

      const readMore = document.querySelector('.single-collaborator .read-more');

      if (readMore) {
        readMore.classList.remove('hidden');

        readMore.addEventListener('click', function () {
          content.style.maxHeight = content.scrollHeight + 'px';

          setTimeout(() => {
            this.classList.add('hidden');
            content.classList.remove('mobile');
          }, 300);
        });
      }
    }
  }
}

export default collaborators;
