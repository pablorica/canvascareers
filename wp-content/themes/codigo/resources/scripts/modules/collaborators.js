const collaborators = () => {
  const years = document.querySelectorAll('.collaborators-year');
  if (years.length > 0) {
    years.forEach(year => {
      year.addEventListener('click', function() {
        const filter = this.getAttribute('data-filter');
        const collaborators = document.querySelectorAll('.collaborators');
        const collaboratorsYear = document.querySelector(`.collaborators-${filter}`);

        // Remove the active class from all years
        years.forEach($year => {
          $year.classList.remove('bg-charcoal', 'text-chalk');
        });

        this.classList.add('bg-charcoal', 'text-chalk');

        // Hide all collaborator sliders
        collaborators.forEach(collaborator => {
          collaborator.classList.add('hidden');
        });

        // Show the selected collaborator slider
        collaboratorsYear.classList.remove('hidden');
      });
    });
  }
}

export default collaborators;
