const jobs = () => {
  // Load Jobs
  function loadJobs() {
    // Get grid element
    const jobs = document.getElementById('jobs');
    let currentFilter = '';

    if (!jobs) {
      return;
    }

    // Filter jobs
    function filterJobs(filterValue) {
      // Filter manually by class
      const jobItems = document.querySelectorAll('.job-item');
      jobItems.forEach((job) => {
        if (!filterValue) {
          job.style.display = 'block';
          return;
        }

        let filter = filterValue.replace('.', '');
        job.style.display = job.classList.contains(filter) ? 'block' : 'none';
      });
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
      const parent = element.parentNode;

      const content = parent.querySelector(`#collapse-${index}`);
      const icon = parent.querySelector(`.icon-${index}`);

      // Toggle the content's max-height for smooth opening and closing
      if (content.style.maxHeight && content.style.maxHeight !== '0px') {
        content.style.maxHeight = '0';
        content.classList.add('overflow-hidden');
        icon.style.transform = 'rotate(0deg)';
      } else {
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.style.transform = 'rotateX(180deg)';

        setTimeout(() => {
          content.classList.remove('overflow-hidden');
        }, 300);
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

              // Search parent job-body
              const jobBody = toggle.closest('.job-body');
              jobBody.style.maxHeight = jobBody.scrollHeight + 'px';
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
                <svg width="20" height="20" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(45deg);">
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

            // Search parent job-body
            const jobBody = form.closest('.job-body');
            if (!jobBody.querySelector('.form-container').classList.contains('hidden')) {
              jobBody.style.maxHeight = jobBody.scrollHeight + 'px';
            }
          }, false);
        }
      });
    }
  }

  // Document ready
  document.addEventListener('DOMContentLoaded', () => {
    loadJobs();
  });
}

export default jobs;
