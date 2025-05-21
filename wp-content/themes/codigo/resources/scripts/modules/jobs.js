const jobs = () => {
  // Load Jobs
  function loadJobs() {
    // Get grid element
    const jobs = document.getElementById('jobs');

    if (!jobs) {
      return;
    }

    let currentFilter = '';
    var jobItems      = document.querySelectorAll('.job-item');
    var numberOfJobs  = jobItems.length;
    var displacement  = 0;

    var previousWidth  = window.innerWidth;
    var previousHeight = window.innerHeight;

    //Default collapsed job height (md viewport)
    var collapsedJobheight = 40;
    //Default min job height (md viewport)
    var jobMinHeight = previousHeight - 144.5 - 108.9 - 95;
    //jobMinHeight = previousHeight - headerHeight - footerHeight - jobsHeaderHeight;

    var mainWrapperHeight = 0;
    var jobsHeaderHeight = 95;
    var marginHeader = 0;
    if(previousWidth > 1024) {
      marginHeader = 5;
    }
    // Select the main element
    const mainWrapper = document.querySelector('main#main');
    if (mainWrapper) {
      mainWrapperHeight = mainWrapper.offsetHeight;
      const jobsHeader = document.querySelector('#jobsListheader');

      if (jobsHeader) {
        jobsHeaderHeight = jobsHeader.offsetHeight + marginHeader;
      }
      jobMinHeight = mainWrapperHeight - jobsHeaderHeight;

      const jobsWrapper = document.querySelector('#jobs');
      if (jobsWrapper) {
        jobsWrapper.style.maxHeight = jobMinHeight + 'px';
      }

    }

    function getCollapsedJobheight() {
      const currentWidth = window.innerWidth;
      if( currentWidth > 768) {
        // md: job height = 40px
        collapsedJobheight = 40;
      }
      if( currentWidth > 1792) {
        // 2xl: job height = 54px
        collapsedJobheight = 54;
      }
    }
    getCollapsedJobheight();

    // Save the min-height data for each job item
    function setMinHeightsAttributes() {
      //console.log('setMinHeightsAttribute');
      if (mainWrapper) {
        mainWrapperHeight = mainWrapper.offsetHeight;
        //console.log('mainWrapperHeight', mainWrapperHeight);

        const jobsHeader = document.querySelector('#jobsListheader');
        if (jobsHeader) {
          jobsHeaderHeight = jobsHeader.offsetHeight + marginHeader;
          //console.log('jobsHeaderHeight', jobsHeaderHeight);
        }
        jobMinHeight = mainWrapperHeight - jobsHeaderHeight;
      }

    }
    setMinHeightsAttributes();

    // Set min height for each job item
    function prepareJobs() {
      const currentWidth = window.innerWidth;
      //This is needed only for desktop
      if( currentWidth <= 768) {
        return;
      }

      displacement = 0;
      if( numberOfJobs > 0 ) {
        displacement = numberOfJobs  * collapsedJobheight;
        if( numberOfJobs >= 4 ) {
          displacement = 4 * collapsedJobheight;
        }
      }
      jobItems.forEach((job) => {
        const jobGrid = job.querySelector('.job-grid');
        jobGrid.style.minHeight = ( jobMinHeight - displacement ) + 'px';
      });
    }
    prepareJobs();

    //Function to close all jobs
    function closeAllJobs(index = null) {
      //console.log('closeAllJobs');
      const accordions = document.getElementsByClassName('job-accordion');
      Array.from(accordions).forEach((accordion, i) => {
        if(index) {
          if (i === index) {
            return;
          }
        }

        const content = accordion.parentNode.querySelector(`#collapse-${i}`);
        const icon = accordion.parentNode.querySelector(`.icon-${i}`);
        const applyButton = accordion.parentNode.querySelector('.toggle-form');
        const formContainer = accordion.parentNode.querySelector('.form-container');

        content.style.maxHeight = '0';
        content.classList.add('overflow-hidden');
        content.classList.remove('overflow-y-scroll');
        icon.style.transform = 'rotate(0deg)';

        // Apply button
        if (applyButton) {
          // If form container is visible, hide it
          if (!formContainer.classList.contains('hidden')) {
            formContainer.classList.add('hidden');
            applyButton.classList.remove('active');
          }
        }
      });
    }

    //Change height values on resize
    window.addEventListener('resize', () => {
      const currentWidth = window.innerWidth;
      const currentHeight = window.innerHeight;

      //This is needed only for desktop
      if( currentWidth <= 768) {
        return;
      }

      closeAllJobs();

      // Check if the width has changed
      if (currentWidth !== previousWidth) {
        const crossedThreshold =
          (previousWidth < 1792 && currentWidth >= 1792) ||
          (previousWidth >= 1792 && currentWidth < 1792);

        if (crossedThreshold) {
          getCollapsedJobheight();
          setMinHeightsAttributes();
          prepareJobs();
        }

        previousWidth = currentWidth;
      }

      // Check if the height has changed
      if (currentHeight !== previousHeight) {
        getCollapsedJobheight();
        setMinHeightsAttributes();
        prepareJobs();

        previousHeight = currentHeight;
      }
    });


    // Filter jobs
    function filterJobs(filterValue) {
      numberOfJobs = 0;
      // Filter manually by class
      jobItems.forEach((job) => {
        if (!filterValue) {
          job.style.display = 'block';
          numberOfJobs = jobItems.length;
          return;
        }

        let filter = filterValue.replace('.', '');
        //job.style.display = job.classList.contains(filter) ? 'block' : 'none';
        job.style.display = 'none';
        if (job.classList.contains(filter)) {
          job.style.display = 'block';
          numberOfJobs++;
        }
      });

      setTimeout(() => {
        prepareJobs()
      }, 100);

    }

    // Get filters
    const filters = document.querySelectorAll('.job-filter');
    // Filter jobs on click
    filters.forEach((filter) => {
      filter.addEventListener('click', (e) => {
        e.preventDefault();

        // Remove active class from all filters
        filters.forEach((filter) => {
          filter.classList.remove('!bg-charcoal');
          filter.classList.remove('!text-chalk');
        });

        // Add active class to clicked filter or remove if already active
        if (filter.getAttribute('data-filter') === currentFilter) {
          currentFilter = '';
        } else {
          currentFilter = filter.getAttribute('data-filter');

          if (currentFilter) {
            filter.classList.toggle('!bg-charcoal');
            filter.classList.toggle('!text-chalk');
          }
        }

        filterJobs(currentFilter);

        closeAllJobs();
      });
    });

    // Filters mobile
    const filtersMobile = document.querySelector('.job-filters-mobile');
    // Open filters on click
    filtersMobile.addEventListener('click', () => {
      // Toggle active class
      filtersMobile.classList.toggle('!bg-charcoal');
      filtersMobile.classList.toggle('!text-chalk');

      // Toggle max-height for smooth opening and closing
      filtersMobile.nextElementSibling.style.maxHeight = filtersMobile.nextElementSibling.style.maxHeight
          ? null
          : filtersMobile.nextElementSibling.scrollHeight + 'px';

      document.querySelector('.job-tags').classList.toggle('border-b');
    });

    // Accordions
    function toggleAccordion(element, index) {
      const currentWidth = window.innerWidth;
      const jobsWrapper = document.querySelector('#jobs');
      const parent = element.parentNode;

      // Hide all other accordions
      closeAllJobs(index);

      const content = parent.querySelector(`#collapse-${index}`);
      const icon = parent.querySelector(`.icon-${index}`);
      const applyButton = parent.querySelector('.toggle-form');
      const formContainer = parent.querySelector('.form-container');

      // Toggle the content's max-height for smooth opening and closing
      if (content.style.maxHeight && content.style.maxHeight !== '0px') {

        // Enable scroll on jobsWrapper when all jobs are closed
        jobsWrapper.classList.remove('overflow-hidden');

        // Hide the content
        content.style.maxHeight = '0';
        content.classList.add('overflow-hidden');
        content.classList.remove('overflow-y-scroll');

        // Reset the icon rotation
        icon.style.transform = 'rotate(0deg)';

        // Apply button
        if (applyButton) {
          // If form container is visible, hide it
          if (!formContainer.classList.contains('hidden')) {
            formContainer.classList.add('hidden');
            applyButton.classList.remove('active');
          }
        }
      } else {

        content.style.maxHeight = content.scrollHeight   + 'px';
        if(currentWidth > 768) {
          content.style.maxHeight = (jobMinHeight - displacement)   + 'px';
        }

        icon.style.transform = 'rotateX(180deg)';
        //console.log('jobMaxHeight', jobMinHeight - displacement);
        //console.log('jobscrollHeight', content.scrollHeight);

        setTimeout(() => {
          content.classList.remove('overflow-hidden');
          content.classList.add('overflow-y-scroll');
        }, 300);

        //console.log('numberOfJobs', numberOfJobs);
        //console.log('index',index);


        //This is needed only for desktop
        if( currentWidth > 768 ) {


          if( numberOfJobs > 4 && index > 3) {
            setTimeout(() => {
              // Scroll up jobsWrapper to show only 4 jobs
              jobsWrapper.scrollTo({
                behavior: 'smooth',
                top: collapsedJobheight  * (index - 3)
              });

            }, 300);
          }
          setTimeout(() => {
            // Disable scroll on jobsWrapper when a job is open
            jobsWrapper.classList.add('overflow-hidden');
          }, 800);
        }


        /*

        const mainScroll = document.querySelector('#main');
            mainScroll.scrollTo({
              behavior: 'smooth',
              top: 100,
            });


        setTimeout(() => {
          // Scroll to accordion
          let jobItemScroll = parent.offsetTop;
          let headerHeight = document.querySelector('#mainMenu').offsetHeight;

          if (window.innerWidth < 768) {
            window.scrollTo({
              behavior: 'smooth',
              top: jobItemScroll - headerHeight + 1,
            });
          } else {
            const mainScroll = document.querySelector('#main');
            mainScroll.scrollTo({
              behavior: 'smooth',
              top: jobItemScroll - headerHeight - 2,
            });
          }

        }, 300);
        */
      }
    }

    const accordions = document.getElementsByClassName('job-accordion');

    if (accordions.length > 0) {
      Array.from(accordions).forEach((accordion, index) => {
        accordion.addEventListener('click', () => toggleAccordion(accordion, index));
      });
    }

    // Forms
    const forms = document.querySelectorAll('.job-form');

    if (forms.length > 0) {
      forms.forEach((form) => {
        // Open and hide form
        const toggleForm = form.querySelectorAll('.toggle-form');

        if (toggleForm) {
          toggleForm.forEach((toggle) => {
            toggle.addEventListener('click', () => {
              form.querySelector('.form-container').classList.toggle('hidden');

              if (form.querySelector('.form-container').classList.contains('hidden')) {
                // Remove active class from all filters
                toggleForm.forEach((toggle) => {
                  toggle.classList.remove('active');
                });
              } else {
                toggle.classList.toggle('active');
              }

              //Mobile only
              if(previousWidth <= 768) {
                // Search parent job-body
                const jobBody = toggle.closest('.job-body');
                jobBody.style.maxHeight = jobBody.scrollHeight + 'px';
              }

            });
          });
        }

        // Add job title from dataset to input field
        let jobTitleInput = form.querySelector('input[name="job-title"]');
        jobTitleInput.value = form.dataset.jobTitle;

        // Add event to add attachment (class .add-attachment)
        let addAttachment = form.querySelector('.add-attachment');

        if (addAttachment) {
          let filesAdded = [];

          addAttachment.addEventListener('click', (e) => {
            e.preventDefault();
            // Check if some of the input fields are empty, if so, trigger the click event to add the file & break the loop
            let inputs = form.querySelectorAll('input[type="file"]');

            for (const input of inputs) {
              if (!input.value) {
                input.click();
                break;
              }
            }
          });

          // Add event listeners to input file
          let inputFiles = form.querySelectorAll('input[type="file"]');
          inputFiles.forEach((inputFile) => {
            inputFile.addEventListener('change', (e) => {
              let fileName = e.target.files[0].name;

              // Add file to array
              filesAdded.push(fileName);

              // Create new element
              let attachment = document.createElement('div');
              attachment.dataset.inputName = e.target.name;
              attachment.classList.add('attachment');

              // Create new element
              let attachmentName = document.createElement('span');
              attachmentName.classList.add('attachment-name');

              // Create new element
              let attachmentRemove = document.createElement('span');
              attachmentRemove.classList.add('attachment-remove');

              // Append elements
              attachmentName.innerHTML = fileName;
              attachmentRemove.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(45deg);">
                 <line x1="25" y1="10" x2="25" y2="40" stroke="black" stroke-width="3"></line>
                 <line x1="10" y1="25" x2="40" y2="25" stroke="black" stroke-width="3"></line>
                </svg>
              `;
              attachment.appendChild(attachmentName);
              attachment.appendChild(attachmentRemove);
              form.querySelector('.attachments .files').appendChild(attachment);

              // Search parent job-body
              const jobBody = form.closest('.job-body');
              jobBody.style.maxHeight = jobBody.scrollHeight + 'px';

              // Add event to remove attachment
              attachmentRemove.addEventListener('click', (e) => {
                let attachment = e.target.closest('.attachment');
                let attachmentName = attachment.querySelector('.attachment-name').innerHTML;
                let index = filesAdded.indexOf(attachmentName);

                if (index > -1) {
                  filesAdded.splice(index, 1);
                }

                let input = form.querySelector(`input[name="${attachment.dataset.inputName}"]`);
                input.value = '';

                attachment.remove();

                // Search parent job-body
                const jobBody = form.closest('.job-body');
                jobBody.style.maxHeight = jobBody.scrollHeight + 'px';
              });
            });
          });

          document.addEventListener('wpcf7submit', function(event) {
            let formId = form.querySelector('input[name="_wpcf7"]').value;
            let submission = event.detail.apiResponse;

            if (submission['contact_form_id'] == formId && submission['status'] != "validation_failed") {
              // Reset files
              let inputFiles = form.querySelectorAll('input[type="file"]');
              inputFiles.forEach((inputFile) => {
                inputFile.value = '';
              });

              // Reset attachments
              let attachments = form.querySelectorAll('.attachment');
              attachments.forEach((attachment) => {
                attachment.remove();
              });

              // Reset filesAdded
              filesAdded = [];
            }

            //Mobile only
            if(previousWidth <= 768) {
              // Search parent job-body
              const jobBody = form.closest('.job-body');
              if (!jobBody.querySelector('.form-container').classList.contains('hidden')) {
               jobBody.style.maxHeight = jobBody.scrollHeight + 'px';
              }
            }

          }, false);
        }
      });
    }
  }

  // Load jobs after 1 second to make sure all elements are loaded
  setTimeout(() => {
    loadJobs();
  }, 1000);
}

export default jobs;
