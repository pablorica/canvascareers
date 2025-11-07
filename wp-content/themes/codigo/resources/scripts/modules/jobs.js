const jobs = () => {
  // Load Jobs
  function loadJobs() {
    // Get grid element
    const jobs = document.getElementById('jobs');

    if (!jobs) {
      return;
    }

    const pagination = document.getElementById('jobsPagination');
    const perpage = pagination?.getAttribute('data-perpage');

    let currentFilter = '';
    var jobsWrapper   = document.querySelector('#jobs');
    var jobItems      = jobsWrapper.querySelectorAll('.job-item');
    var numberOfJobs  = jobItems.length;
    var displacement  = 0;

    var previousWidth  = window.innerWidth;
    var previousHeight = window.innerHeight;

    //Default collapsed job height (md viewport)
    var collapsedJobheight = 40;
    //Default min job height (md viewport)
    var jobDashboardMinHeight = previousHeight - 144.5 - 108.9 - 95;
    //jobDashboardMinHeight = previousHeight - headerHeight - footerHeight - jobsHeaderHeight;


    //Function to close all jobs
    function closeAllJobs(
      index = null,
      numberofvisibleJobs = 0
    ) {
      const accordions = Array.from(document.getElementsByClassName('job-accordion'));
      const totalItems = accordions.length;

      // Reset all items
      accordions.forEach((accordion) => {
        const parent = accordion.parentNode;
        parent.classList.remove('visible', 'opened');
      });

      if (index !== null && numberofvisibleJobs > 0) {
        // Calculate how many before and after
        const half = Math.floor(numberofvisibleJobs / 2);

        //const extraBefore = numberofvisibleJobs % 2 === 1 ? 1 : 0;
        //let beforeTarget = half + extraBefore;
        //let afterTarget = numberofvisibleJobs - beforeTarget;

        const extraAfter = numberofvisibleJobs % 2 === 1 ? 1 : 0;
        let afterTarget = half + extraAfter;
        let beforeTarget = numberofvisibleJobs - afterTarget;

        const visibleIndices = [];

        // Look backwards
        let i = index - 1;
        let collectedBefore = 0;
        while (i >= 0 && collectedBefore < beforeTarget) {
          if (!accordions[i].parentNode.classList.contains('hidden') ) {
            //console.log('Adding before index, element number', i);
            visibleIndices.unshift(i);
            collectedBefore++;
          }
          i--;
        }

        // Look forwards
        let l = index + 1;
        let collectedAfter = 0;
        while (l < totalItems && collectedAfter < afterTarget) {
          if (!accordions[l].parentNode.classList.contains('hidden')) {
            //console.log('Adding after index, element number', l);
            visibleIndices.push(l);
            collectedAfter++;
          }
          l++;
        }

        // Try to compensate if before or after were short
        let stillNeeded = numberofvisibleJobs - (collectedBefore + collectedAfter);
        let m = index - collectedBefore - 1;
        //console.log('collectedBefore', collectedBefore);
        //console.log('collectedAfter', collectedAfter);
        //console.log('stillNeeded', stillNeeded);
        while (m >= 0 && stillNeeded > 0) {
          if (!accordions[m].parentNode.classList.contains('hidden')
            && visibleIndices.indexOf(m) === -1
          ) {
            visibleIndices.unshift(m);
            //console.log('Adding  much before index, element number', m);
            stillNeeded--;
          }
          m--;
        }

        let j = index + collectedAfter + 1;
        //console.log('totalItems', totalItems);
        while (j < totalItems && stillNeeded > 0) {
          if (!accordions[j].parentNode.classList.contains('hidden')
            && visibleIndices.indexOf(j) === -1
          ) {
            visibleIndices.push(j);
            //console.log('Adding much after index, element number', j);
            //console.log('Element', accordions[j].parentNode.classList);
            stillNeeded--;
          }
          j++;
        }

        //remove duplicates
        const uniqueVisibleIndices = [...new Set(visibleIndices)];

        // Add 'visible' class
        uniqueVisibleIndices.forEach((k) => {
          accordions[k].parentNode.classList.add('visible');
          //console.log('Adding visible class to item ', k);
          //console.log('Added to ', accordions[k].parentNode.classList);
        });
      }

      // Collapse all except the selected one
      accordions.forEach((accordion, i) => {
        if (index !== null && i === index) return;

        const parent = accordion.parentNode;
        const content = parent.querySelector(`#collapse-${i}`);
        const icon = parent.querySelector(`.icon-${i}`);
        const applyButton = parent.querySelector('.toggle-form');
        const formContainer = parent.querySelector('.form-container');

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

    //Close jobs on resize
    window.addEventListener('resize', () => {
      const currentWidth = window.innerWidth;
      const currentHeight = window.innerHeight;

      jobDashboardMinHeight = currentHeight - 144.5 - 108.9 - 95;

      //This is needed only for desktop
      if( currentWidth <= 768) {
        return;
      }
      jobsWrapper.classList.remove('hide-jobs');
      pagination.classList.remove('hidden');
      closeAllJobs();

    });


    // Filter jobs
    function filterJobs(filterValue) {
      numberOfJobs = 0;
      // Filter manually by class
      jobItems.forEach((job) => {
        if (!filterValue) {
          job.classList.remove('hidden');
          numberOfJobs = jobItems.length;
          setOrigPagJob(job, true);
          return;
        }

        let filter = filterValue.replace('.', '');
        job.classList.add('hidden');
        setOrigPagJob(job, false);
        if (job.classList.contains(filter)) {
          job.classList.remove('hidden');
          numberOfJobs++;
          setPagJob(job, numberOfJobs);
        }
      });

      resetpagination();

      setTimeout(() => {
        //prepareJobs()
      }, 100);

    }

    function setPagJob(job, number) {
      //console.log('setting page for job number', number, perpage);
      for (let i = 1; i <= 100; i++) {
        if (job.classList.contains(`page-${i}`)) {
          job.classList.remove(`page-${i}`);
          break;
        }
      }
      let currentpage = Math.ceil(number / perpage);
      job.classList.add(`page-${currentpage}`);
    }
    function setOrigPagJob(job, reset) {
      for (let i = 1; i <= 100; i++) {
        if (job.classList.contains(`page-${i}`)) {
          job.classList.remove(`page-${i}`);
          if ([...job.classList].some(className => className.startsWith('page-original'))) {
            //console.log('The job element already has a class starting with "page-original".');
          } else {
            job.classList.add(`page-original-${i}`);
          }
          break;
        }
      }
      if (reset) {
        for (let i = 1; i <= 100; i++) {
          if (job.classList.contains(`page-original-${i}`)) {
            job.classList.remove(`page-original-${i}`);
            job.classList.add(`page-${i}`);
            break;
          }
        }
      }
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
        jobsWrapper.classList.remove('hide-jobs');
        pagination.classList.remove('hidden');
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
      const parent       = element.parentNode;

      const content       = parent.querySelector(`#collapse-${index}`);
      const icon          = parent.querySelector(`.icon-${index}`);
      const applyButton   = parent.querySelector('.toggle-form');
      const formContainer = parent.querySelector('.form-container');

      let dashboardLeftSpace = jobDashboardMinHeight - content.scrollHeight;
      let numberofvisibleJobs = Math.floor(dashboardLeftSpace/ collapsedJobheight);
      //console.log('jobDashboardMinHeight', jobDashboardMinHeight);
      //console.log('numberofvisibleJobs', numberofvisibleJobs);
      //console.log('opened Job', index);

      // Hide all other accordions
      closeAllJobs(index, numberofvisibleJobs);

      parent.classList.remove('opened');

      // Toggle the content's max-height for smooth opening and closing
      if (content.style.maxHeight && content.style.maxHeight !== '0px') {

        // Enable scroll on jobsWrapper when all jobs are closed
        jobsWrapper.classList.remove('overflow-hidden');
        //Remove all classes starting by show-jobs
        jobsWrapper.classList.remove('hide-jobs');
        pagination.classList.remove('hidden');

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

        parent.classList.add('opened');

        content.style.maxHeight = content.scrollHeight   + 'px';

        icon.style.transform = 'rotateX(180deg)';


        jobsWrapper.classList.add('hide-jobs');
        pagination.classList.add('hidden');


        setTimeout(() => {
          //content.classList.remove('overflow-hidden');
          //content.classList.add('overflow-y-scroll');
        }, 300);

        //console.log('numberOfJobs', numberOfJobs);
        //console.log('index',index);


        //This is needed only for desktop
        if( currentWidth > 768 ) {

          setTimeout(() => {
            // Disable scroll on jobsWrapper when a job is open
            //jobsWrapper.classList.add('overflow-hidden');
          }, 800);
        }
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
              const formContainer = form.querySelector('.form-container');
              // Check if formContainer exists
              if (!formContainer) {
                console.error('Element .form-container not found.');
                return;
              }

              formContainer.classList.toggle('hidden');

              if (formContainer.classList.contains('hidden')) {
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

                // Scroll the window to the same height as formContainer
                setTimeout(() => {
                  const formTopOffset = formContainer.getBoundingClientRect().top + window.scrollY;
                  window.scrollTo({
                    top: formTopOffset,
                    behavior: 'smooth'
                  });
                }, 500);
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

          let checkMaxFiles = () => {
            //if filesAdded is full, disable addAttachment button
            if (filesAdded.length >= 3) {
              addAttachment.classList.add('disabled');
              addAttachment.setAttribute('disabled', 'disabled');
              console.log('Max files added');
            } else {
              addAttachment.classList.remove('disabled');
              addAttachment.removeAttribute('disabled');
            }
          }

          let checkInputFile = (fileName, inputName) => {

            // console.log('Added InputName', inputName);
            // console.log('Added InputFile', fileName);

            //Check if file is already added
            if (filesAdded.includes(fileName)) {
              return;
            }

            // Add file to array
            filesAdded.push(fileName);

            // Create new element
            let attachment = document.createElement('div');
            attachment.dataset.inputName = inputName;
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
            //const jobBody = form.closest('.job-body');
            //jobBody.style.maxHeight = jobBody.scrollHeight + 'px';


            //console.log('checkFilesAdded', filesAdded);
            //for (const input of form.querySelectorAll('input[type="file"]')) {
              //console.log('input.value', input.value);
            //}

            checkMaxFiles();

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
              //const jobBody = form.closest('.job-body');
              //jobBody.style.maxHeight = jobBody.scrollHeight + 'px';

              // console.log('removed element', attachmentName);
              // console.log('checkFilesAdded', filesAdded);
              // for (const input of form.querySelectorAll('input[type="file"]')) {
              //   console.log('input.value', input.value);
              // }

              checkMaxFiles();
            });
          }


          addAttachment.addEventListener('click', (e) => {
            e.preventDefault();
            // Check if some of the input fields are empty, if so, trigger the click event to add the file & break the loop
            let inputs = form.querySelectorAll('input[type="file"]');

            for (const input of inputs) {
              console.log('input.value', input.value);
              if (!input.value) {
                input.click();
                break;
              }
            }
          });

          // Add event listeners to input file
          let inputFiles = form.querySelectorAll('input[type="file"]');
          inputFiles.forEach((inputFile) => {

            if (inputFile.value) {
              // get the value of the input file
              let fileName = inputFile.value.split('\\').pop();
              //get the name of the input file
              let inputName = inputFile.name;

              checkInputFile(fileName, inputName);
            }

            inputFile.addEventListener('change', (e) => {
              let fileName  = e.target.files[0].name;
              let inputName = e.target.name;
              checkInputFile(fileName, inputName);
            });
          });

          document.addEventListener('wpcf7submit', function(event) {
            let formId = form.querySelector('input[name="_wpcf7"]').value;
            let submission = event.detail.apiResponse;

            if (submission['contact_form_id'] == formId
                && submission['status'] != "validation_failed"
            ) {
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
              checkMaxFiles();
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


    //Get all .pagination-item elements
    const paginationItems = pagination ? pagination.querySelectorAll('.pagination-item') : [];

    function resetpagination() {
      if (paginationItems.length > 0) {
        // Remove active class from all pagination items
        paginationItems.forEach((paginationItem) => {
          paginationItem.classList.remove('bg-charcoal');
          paginationItem.classList.add('bg-gray');
        });

        // Add active class to first pagination item
        const firstItem = pagination.querySelector('.pagination-item[data-page="1"]');
        if (firstItem) {
          firstItem.classList.add('bg-charcoal');
          firstItem.classList.remove('bg-gray');
        }

        // Hide job items - Show first page
        jobItems.forEach((job) => {
          job.classList.add('hidden');
          if (job.classList.contains(`page-1`)) {
            job.classList.remove('hidden');
          }
        });

        let numberOfDots = Math.ceil(numberOfJobs / perpage);
        //Hide last numberOfDots pagination items
        paginationItems.forEach((item) => {
          let page = item.getAttribute('data-page');
          if (page > numberOfDots) {
            item.classList.add('hidden');
          } else {
            item.classList.remove('hidden');
          }
        });
      }
    }

    if (paginationItems.length > 0) {

      paginationItems.forEach((item) => {
        item.addEventListener('click', (e) => {
          e.preventDefault();
          const page = item.getAttribute('data-page');

          // Remove active class from all pagination items
          paginationItems.forEach((paginationItem) => {
            paginationItem.classList.remove('bg-charcoal');
            paginationItem.classList.add('bg-gray');
          });

          // Add active class to clicked pagination item
          item.classList.add('bg-charcoal');
          item.classList.remove('bg-gray');

          // Show/Hide job items
          jobItems.forEach((job) => {
            job.classList.add('hidden');
            if (job.classList.contains(`page-${page}`)) {
              job.classList.remove('hidden');
            }
          });

          // Close all jobs
          jobsWrapper.classList.remove('hide-jobs');
          pagination.classList.remove('hidden');
          closeAllJobs();
        });
      });
    }
  }

  // Load jobs after 1 second to make sure all elements are loaded
  setTimeout(() => {
    loadJobs();
  }, 1000);
}

export default jobs;
