const collaborators = () => {

  // Apply selected state + show/hide panels
  const applyFilter = (btn, buttons, panels, selectedPanel) => {
    //console.log('Filter by year',fyear);
    //console.log('Filter by season',fseason);

    // button styles
    buttons.forEach(b => b.classList.remove('!bg-charcoal', '!text-chalk'));
    btn.classList.add('!bg-charcoal', '!text-chalk');

    // panels visibility
    panels.forEach(p => p.classList.add('hidden'));
    selectedPanel?.classList.remove('hidden');
  };

  let fyear   = ""; // data-year
  let fseason = ""; // data-season

  const panels  = document.querySelectorAll('#collaborators .collaborators');          // all content panels
  const years   = document.querySelectorAll('#collaborators .collaborators-year');      // year buttons
  const seasons = document.querySelectorAll('#collaborators .collaborators-season');  // season buttons

  //get the classes of the  panel that is not hidden

  const activePanel = document.querySelector('#collaborators .collaborators:not(.hidden)');
  if (activePanel) {
    //const classes = activePanel.className.split(' ');
    const classes = activePanel.className.trim().split(/\s+/);
    classes.forEach(c => {
      if (c.startsWith('year-')) {
        fyear = c.replace('year-', '');
      }
      if (c.startsWith('season-')) {
        fseason = c.replace('season-', '');
      }
    });
  }

  //console.log('Initial filter:', fyear, fseason);
  //console.log(typeof fyear, typeof fseason);

  if (years.length) {
    years.forEach(btn => {
      btn.addEventListener('click', () => {
        fyear = btn.dataset.year; // data-year
        // const panel = document.querySelector(
        //   `#collaborators .year-${CSS.escape(fyear)}`
        // );
        const panel = document.querySelector(
          `#collaborators .year-${CSS.escape(fyear)}.season-${CSS.escape(fseason)}`
        );
        //console.log('Selected panel:', `#collaborators .year-${CSS.escape(fyear)}.season-${CSS.escape(fseason)}`);
        applyFilter(btn, years, panels, panel);

        //Hide all .collaborators-season buttons except those with data-year="fyear"
        seasons.forEach(seasonBtn => {
          if (seasonBtn.dataset.year === fyear) {
            //Find parent with tag 'ul' and hide it
            seasonBtn.closest('ul').classList.remove('hidden');
            seasonBtn.closest('ul').classList.add('flex');
          } else {
            seasonBtn.closest('ul').classList.remove('flex');
            seasonBtn.closest('ul').classList.add('hidden');
          }

          //Set selected state on season button
          if (seasonBtn.dataset.season === fseason) {
            seasonBtn.classList.add('!bg-charcoal', '!text-chalk');
          }
        });

      });
    });
  }

  // Seasons
  if (seasons.length) {
    seasons.forEach(btn => {
      btn.addEventListener('click', () => {
        fseason = btn.dataset.season; // data-season

        const panel = document.querySelector(
          `#collaborators .year-${CSS.escape(fyear)}.season-${CSS.escape(fseason)}`
        );
        //console.log('Selected panel:', `#collaborators .year-${CSS.escape(fyear)}.season-${CSS.escape(fseason)}`);
        applyFilter(btn, seasons, panels, panel);
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
