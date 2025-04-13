document.addEventListener("DOMContentLoaded", function () {
  // Base URL for all AJAX requests
  const apiUrl = "../admin/ajax_handler.php";

  // Initialize login form if it exists
  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);
      const submitButton = this.querySelector('button[type="submit"]');
      const alertContainer = document.getElementById("alert-container");

      // Disable button and show loading state
      submitButton.disabled = true;
      submitButton.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...';

      fetch("login.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show success message
            Swal.fire({
              icon: "success",
              title: "Success",
              text: data.message,
              timer: 1500,
              showConfirmButton: false,
            }).then(() => {
              // Redirect to dashboard or specified page
              window.location.href = data.redirect || "index.php";
            });
          } else {
            // Show error message
            alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              ${data.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;

            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = "Login";
          }
        })
        .catch((error) => {
          console.error("Error:", error);

          alertContainer.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            An unexpected error occurred. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;

          // Reset button state
          submitButton.disabled = false;
          submitButton.textContent = "Login";
        });
    });
  }

  // Initialize registration form if it exists
  const registrationForm = document.getElementById("registrationForm");
  if (registrationForm) {
    registrationForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);
      const submitButton = this.querySelector('button[type="submit"]');
      const alertContainer = document.getElementById("alert-container");

      // Disable button and show loading state
      submitButton.disabled = true;
      submitButton.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating User...';

      fetch("add_admin.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show success message
            Swal.fire({
              icon: "success",
              title: "User Created Successfully",
              text: data.message,
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              // Reset form
              registrationForm.reset();
              // Redirect if specified
              if (data.redirect) {
                window.location.href = data.redirect;
              }
            });
          } else {
            // Show error message
            alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              ${data.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;
          }

          // Reset button state
          submitButton.disabled = false;
          submitButton.textContent = "Create User";
        })
        .catch((error) => {
          console.error("Error:", error);

          alertContainer.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            An unexpected error occurred. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;

          // Reset button state
          submitButton.disabled = false;
          submitButton.textContent = "Create User";
        });
    });
  }

  // Common utility functions accessible globally
  window.adminUtils = {
    // Function to display alerts using SweetAlert2
    showAlert: function (message, type = "success") {
      const icon = type === "success" ? "success" : "error";
      const title = type === "success" ? "Success" : "Error";

      Swal.fire({
        icon: icon,
        title: title,
        text: message,
        timer: type === "success" ? 3000 : 5000,
        timerProgressBar: true,
        showConfirmButton: type !== "success",
        toast: type === "success",
        position: type === "success" ? "top-end" : "center",
      });
    },

    // Show success message with SweetAlert2
    showSuccess: function (message) {
      Swal.fire({
        icon: "success",
        title: "Success",
        text: message,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
      });
    },

    // Show error message with SweetAlert2
    showError: function (message) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: message,
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonColor: "#d33",
      });
    },

    // Show confirmation dialog with SweetAlert2
    showConfirmation: function (title, text, callback) {
      Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, proceed!",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          callback();
        }
      });
    },

    // Initialize email settings controls
    initEmailSettings: function () {
      // Show/hide SMTP settings based on mail driver selection
      const mailDriverSelect = document.getElementById("mail_mailer");

      if (mailDriverSelect) {
        mailDriverSelect.addEventListener("change", function () {
          const smtpSettings = document.getElementById("smtp-settings");
          if (this.value === "smtp") {
            smtpSettings.classList.remove("d-none");
          } else {
            smtpSettings.classList.add("d-none");
          }
        });
      }

      // Test email configuration button
      const testEmailBtn = document.getElementById("test-email-btn");

      if (testEmailBtn) {
        testEmailBtn.addEventListener("click", function () {
          const formData = new FormData(
            document.getElementById("emailSettingsForm")
          );
          formData.append("event", "test_email_config");

          // Show loading state
          this.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Testing...';
          this.disabled = true;

          fetch("../admin/function.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.json())
            .then((data) => {
              // Reset button
              this.innerHTML = "Test Email Configuration";
              this.disabled = false;

              if (data.success) {
                window.adminUtils.showAlert(
                  data.message || "Test email sent successfully!",
                  "success"
                );
              } else {
                window.adminUtils.showAlert(
                  data.error || "Error sending test email",
                  "danger"
                );
              }
            })
            .catch((error) => {
              // Reset button
              this.innerHTML = "Test Email Configuration";
              this.disabled = false;

              window.adminUtils.showAlert("Error: " + error.message, "danger");
            });
        });
      }
    },

    // Initialize image previews
    setupImagePreviews: function () {
      const fileInputs = document.querySelectorAll('input[type="file"]');
      fileInputs.forEach((input) => {
        input.addEventListener("change", function () {
          if (this.files && this.files[0]) {
            const previewClass =
              this.id === "favicon" ? "favicon-preview" : "preview-image";
            let previewContainer = this.nextElementSibling;

            // Create container if it doesn't exist
            if (!previewContainer || !previewContainer.querySelector("img")) {
              if (previewContainer && !previewContainer.querySelector("img")) {
                // Container exists but no image
              } else {
                // Create new container
                previewContainer = document.createElement("div");
                previewContainer.className = "mt-2";
                this.parentNode.appendChild(previewContainer);
              }

              // Create image element
              const img = document.createElement("img");
              img.className = previewClass;
              img.alt = "Preview";
              previewContainer.appendChild(img);
            }

            // Update image src
            const reader = new FileReader();
            const img = previewContainer.querySelector("img");

            reader.onload = function (e) {
              img.src = e.target.result;
            };

            reader.readAsDataURL(this.files[0]);
          }
        });
      });
    },

    // Initialize all form handlers for the settings page
    initSettingsForms: function () {
      // Handle general settings form submit
      if (document.getElementById("generalSettingsForm")) {
        document
          .getElementById("generalSettingsForm")
          .addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("event", "save_general_settings");

            fetch("../admin/function.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  window.adminUtils.showAlert(
                    data.message || "General settings saved successfully",
                    "success"
                  );
                } else {
                  window.adminUtils.showAlert(
                    data.error || "Error saving general settings",
                    "error"
                  );
                }
              })
              .catch((error) => {
                window.adminUtils.showAlert("Error: " + error.message, "error");
              });
          });
      }

      // Handle SEO settings form submit
      if (document.getElementById("seoSettingsForm")) {
        document
          .getElementById("seoSettingsForm")
          .addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("event", "save_seo_settings");

            fetch("../admin/function.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  window.adminUtils.showAlert(
                    data.message || "SEO settings saved successfully",
                    "success"
                  );
                } else {
                  window.adminUtils.showAlert(
                    data.error || "Error saving SEO settings",
                    "error"
                  );
                }
              })
              .catch((error) => {
                window.adminUtils.showAlert("Error: " + error.message, "error");
              });
          });
      }

      // Handle social media settings form submit
      if (document.getElementById("socialSettingsForm")) {
        document
          .getElementById("socialSettingsForm")
          .addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("event", "save_social_settings");

            fetch("../admin/function.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  window.adminUtils.showAlert(
                    data.message || "Social media settings saved successfully",
                    "success"
                  );
                } else {
                  window.adminUtils.showAlert(
                    data.error || "Error saving social media settings",
                    "error"
                  );
                }
              })
              .catch((error) => {
                window.adminUtils.showAlert("Error: " + error.message, "error");
              });
          });
      }

      // Handle email settings form submit
      if (document.getElementById("emailSettingsForm")) {
        document
          .getElementById("emailSettingsForm")
          .addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append("event", "save_email_settings");

            fetch("../admin/function.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  window.adminUtils.showAlert(
                    data.message || "Email settings saved successfully",
                    "success"
                  );
                } else {
                  window.adminUtils.showAlert(
                    data.error || "Error saving email settings",
                    "error"
                  );
                }
              })
              .catch((error) => {
                window.adminUtils.showAlert("Error: " + error.message, "error");
              });
          });
      }
    },

    // Initialize DataTables for all admin tables
    initDataTables: function () {
      // Add a check to make sure jQuery and DataTables are loaded
      if (typeof $ === "undefined" || typeof $.fn.DataTable === "undefined") {
        console.error("jQuery or DataTables not loaded");
        return;
      }

      // Initialize DataTables with common configuration
      if ($("#blogTableBody").length) {
        $("#blogTableBody")
          .closest("table")
          .DataTable({
            language: {
              search: "Search blogs:",
              lengthMenu: "Show _MENU_ blogs per page",
              info: "Showing _START_ to _END_ of _TOTAL_ blogs",
              infoEmpty: "Showing 0 to 0 of 0 blogs",
              infoFiltered: "(filtered from _MAX_ total blogs)",
            },
            pageLength: 10,
            responsive: true,
          });
      }

      if ($("#eventTableBody").length) {
        $("#eventTableBody")
          .closest("table")
          .DataTable({
            language: {
              search: "Search events:",
              lengthMenu: "Show _MENU_ events per page",
              info: "Showing _START_ to _END_ of _TOTAL_ events",
              infoEmpty: "Showing 0 to 0 of 0 events",
              infoFiltered: "(filtered from _MAX_ total events)",
            },
            pageLength: 10,
            responsive: true,
          });
      }

      if ($("#serviceTableBody").length) {
        $("#serviceTableBody")
          .closest("table")
          .DataTable({
            language: {
              search: "Search services:",
              lengthMenu: "Show _MENU_ services per page",
              info: "Showing _START_ to _END_ of _TOTAL_ services",
              infoEmpty: "Showing 0 to 0 of 0 services",
              infoFiltered: "(filtered from _MAX_ total services)",
            },
            pageLength: 10,
            responsive: true,
          });
      }

      if ($("#categoryTableBody").length) {
        $("#categoryTableBody")
          .closest("table")
          .DataTable({
            language: {
              search: "Search categories:",
              lengthMenu: "Show _MENU_ categories per page",
              info: "Showing _START_ to _END_ of _TOTAL_ categories",
              infoEmpty: "Showing 0 to 0 of 0 categories",
              infoFiltered: "(filtered from _MAX_ total categories)",
            },
            pageLength: 10,
            responsive: true,
          });
      }

      if ($("#contactTableBody").length) {
        $("#contactTableBody")
          .closest("table")
          .DataTable({
            language: {
              search: "Search messages:",
              lengthMenu: "Show _MENU_ messages per page",
              info: "Showing _START_ to _END_ of _TOTAL_ messages",
              infoEmpty: "Showing 0 to 0 of 0 messages",
              infoFiltered: "(filtered from _MAX_ total messages)",
            },
            pageLength: 10,
            responsive: true,
            columnDefs: [
              {
                // Limit message content display length
                targets: 3,
                render: function (data, type, row) {
                  if (type === "display" && data.length > 40) {
                    return data.substr(0, 40) + "...";
                  }
                  return data;
                },
              },
            ],
          });
      }
    },

    // Initialize settings page
    initSettingsPage: function () {
      this.initEmailSettings();
      this.initSettingsForms();
    },

    // Initialize contact page message detail handling
    initContactPage: function () {
      // Event delegation for view message buttons
      const contactTable = document.getElementById("contactTableBody");
      if (contactTable) {
        contactTable.addEventListener("click", function (e) {
          if (e.target && e.target.classList.contains("btn-view-message")) {
            const messageData = JSON.parse(
              e.target.getAttribute("data-message")
            );

            // Populate modal with message details
            document.getElementById("detail-name").textContent =
              messageData.name || "";
            document.getElementById("detail-email").textContent =
              messageData.email || "";
            document.getElementById("detail-subject").textContent =
              messageData.subject || "";
            document.getElementById("detail-message").textContent =
              messageData.message || "";
            document.getElementById("detail-date").textContent =
              messageData.submission_date || "";
            document.getElementById("detail-category").textContent =
              messageData.category_name || "None";

            // Set up reply button
            document.getElementById("btn-reply-email").onclick = function () {
              window.location.href = `mailto:${messageData.email}?subject=Re: ${messageData.subject}`;
            };

            // Show modal
            const messageModal = new bootstrap.Modal(
              document.getElementById("messageModal")
            );
            messageModal.show();
          }
        });
      }
    },

    // Initialize page based on page type
    initPage: function (pageType) {
      if (pageType === "settings") {
        this.initSettingsPage();
      } else if (pageType === "contact") {
        this.initContactPage();
      }

      // Setup other common functionality
      this.setupImagePreviews();

      // Initialize DataTables (with a slight delay to ensure the tables are loaded)
      setTimeout(() => {
        this.initDataTables();
      }, 500);
    },
  };

  /**
   * Generic AJAX handler function that can be used across the application
   * @param {string} event - The event name to be processed by function.php
   * @param {object} data - The data to be sent with the request
   * @param {function} callback - The callback function to handle the response
   */
  function ajaxRequest(event, data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", apiUrl, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            // Check if the response starts with HTML (likely an error)
            if (xhr.responseText.trim().startsWith("<")) {
              console.error(
                "Server returned HTML instead of JSON. First 100 characters:",
                xhr.responseText.substring(0, 100)
              );

              // Use SweetAlert for error message
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "Server returned HTML instead of JSON. Check server logs for details.",
              });

              callback({
                error:
                  "Server returned HTML instead of JSON. Check server logs for details.",
              });
              return;
            }

            const response = JSON.parse(xhr.responseText);
            callback(response);
          } catch (error) {
            console.error("Error parsing JSON response:", error);
            console.error(
              "Response text (first 100 chars):",
              xhr.responseText.substring(0, 100)
            );
            callback({ error: "Invalid JSON response from server" });
          }
        } else {
          console.error("AJAX request failed with status:", xhr.status);
          console.error("Response text:", xhr.responseText);
          callback({ error: `Request failed with status ${xhr.status}` });
        }
      }
    };

    // Add error handling for network issues
    xhr.onerror = function () {
      console.error("Network error occurred");
      callback({ error: "Network error occurred" });
    };

    // Send the request
    try {
      xhr.send(JSON.stringify({ event, ...data }));
    } catch (error) {
      console.error("Error sending request:", error);
      callback({ error: "Error sending request: " + error.message });
    }
  }

  /**
   * Creates a common interface for managing any type of entity (blogs, events, services, categories)
   * @param {string} entityType - The type of entity (blogs, events, services, categories)
   * @param {string} tableId - The ID of the table body element
   * @param {string} modalId - The ID of the modal element
   * @param {string} formId - The ID of the form element
   * @returns {object} An object with methods for fetching, creating, updating, and deleting entities
   */
  function createEntityManager(entityType, tableId, modalId, formId) {
    // Check if the required elements exist on the page
    const tableBody = document.getElementById(tableId);
    const modalElement = document.getElementById(modalId);
    const formElement = document.getElementById(formId);

    // If the required elements don't exist, return a dummy object
    if (!tableBody) {
      console.log(
        `Table body with ID '${tableId}' not found, skipping '${entityType}' initialization`
      );
      return {
        fetch: function () {},
        post: function () {},
        edit: function () {},
        delete: function () {},
        loadCategories: function () {},
      };
    }

    const singular = entityType.replace(/s$/, "");

    return {
      fetch: function () {
        ajaxRequest(`fetch_${entityType}`, {}, function (response) {
          if (!tableBody) return;
          tableBody.innerHTML = "";

          if (Array.isArray(response)) {
            response.forEach(function (item) {
              const row = document.createElement("tr");

              // Create title cell
              const titleCell = document.createElement("td");
              titleCell.textContent = item.title || item.name || "";
              row.appendChild(titleCell);

              // Create second column (type for categories, description for others)
              const secondCell = document.createElement("td");
              if (entityType === "categories") {
                secondCell.textContent = item.type || "";
              } else {
                secondCell.textContent =
                  item.description || item.short_description || "";
              }
              row.appendChild(secondCell);

              // Create third column cell (category_name, event_date, or description for categories)
              const thirdCell = document.createElement("td");
              if (entityType === "categories") {
                thirdCell.textContent = item.description || "";
              } else if (entityType === "events") {
                thirdCell.textContent = item.event_date || "";
              } else {
                // Display category_name instead of category_id
                thirdCell.textContent = item.category_name || "";
              }
              row.appendChild(thirdCell);

              // Special case for contact_submissions - we need to show more columns
              if (entityType === "contact_submissions") {
                // Clear the row and create a new structure
                row.innerHTML = "";

                // Name
                const nameCell = document.createElement("td");
                nameCell.textContent = item.name || "";
                row.appendChild(nameCell);

                // Email
                const emailCell = document.createElement("td");
                emailCell.textContent = item.email || "";
                row.appendChild(emailCell);

                // Subject
                const subjectCell = document.createElement("td");
                subjectCell.textContent = item.subject || "";
                row.appendChild(subjectCell);

                // Message (truncated)
                const messageCell = document.createElement("td");
                const messageText = item.message || "";
                messageCell.textContent =
                  messageText.length > 50
                    ? messageText.substring(0, 50) + "..."
                    : messageText;
                row.appendChild(messageCell);

                // Category
                const categoryCell = document.createElement("td");
                categoryCell.textContent = item.category_name || "None";
                row.appendChild(categoryCell);

                // Date
                const dateCell = document.createElement("td");
                dateCell.textContent = item.submission_date || "";
                row.appendChild(dateCell);

                // Add view button to the last cell
                const actionCell = document.createElement("td");
                const viewBtn = document.createElement("button");
                viewBtn.className = "btn btn-sm btn-info btn-view-message";
                viewBtn.textContent = "View";
                viewBtn.setAttribute("data-message", JSON.stringify(item));
                actionCell.appendChild(viewBtn);
                row.appendChild(actionCell);

                tableBody.appendChild(row);
                return; // Skip the rest of the processing for contact submissions
              }

              // Create actions cell with edit and delete buttons
              const actionCell = document.createElement("td");

              const editBtn = document.createElement("button");
              editBtn.className = "btn btn-warning me-2";
              editBtn.textContent = "Edit";
              editBtn.onclick = function () {
                window[entityType].edit(item);
              };
              actionCell.appendChild(editBtn);

              const deleteBtn = document.createElement("button");
              deleteBtn.className = "btn btn-danger";
              deleteBtn.textContent = "Delete";
              deleteBtn.onclick = function () {
                window[entityType].delete(item.id);
              };
              actionCell.appendChild(deleteBtn);

              row.appendChild(actionCell);
              tableBody.appendChild(row);
            });
          } else {
            console.error(`Expected an array but got:`, response);
          }
        });
      },

      post: function () {
        if (!formElement) {
          console.error(`Form with ID '${formId}' not found`);
          return;
        }

        const formData = new FormData(formElement);
        const data = Object.fromEntries(formData.entries());

        const eventName = data.id ? `update_${singular}` : `post_${singular}`;

        ajaxRequest(eventName, data, function (response) {
          if (response.error) {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: `Error: ${response.error}`,
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Success",
              text: response.message || `${singular} saved successfully`,
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
              toast: true,
              position: "top-end",
            });

            // Close modal if it exists
            if (modalElement) {
              const modal = bootstrap.Modal.getInstance(modalElement);
              if (modal) modal.hide();
            }

            // Reset form
            formElement.reset();

            // Refresh data
            window[entityType].fetch();
          }
        });
      },

      edit: function (item) {
        if (!formElement) {
          console.error(`Form with ID '${formId}' not found`);
          return;
        }

        // Populate form fields
        for (const key in item) {
          const input =
            formElement.elements[key] || document.getElementById(key);
          // Skip file inputs - they can't have their values set programmatically
          if (input && input.type !== "file") {
            input.value = item[key];
          }
        }

        // Show modal if it exists
        if (modalElement) {
          const modal = new bootstrap.Modal(modalElement);
          modal.show();
        }
      },

      delete: function (id) {
        Swal.fire({
          title: `Delete ${singular}?`,
          text: `Are you sure you want to delete this ${singular}? This cannot be undone.`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "Cancel",
        }).then((result) => {
          if (result.isConfirmed) {
            ajaxRequest(`delete_${singular}`, { id: id }, function (response) {
              if (response.error) {
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: `Error: ${response.error}`,
                });
              } else {
                Swal.fire({
                  icon: "success",
                  title: "Deleted!",
                  text: response.message || `${singular} deleted successfully`,
                  timer: 2000,
                  timerProgressBar: true,
                  showConfirmButton: false,
                  toast: true,
                  position: "top-end",
                });
                window[entityType].fetch();
              }
            });
          }
        });
      },

      loadCategories: function (type, selectId) {
        const select = document.getElementById(selectId);
        if (!select) return;

        ajaxRequest(
          "fetch_categories_by_type",
          { type: type },
          function (response) {
            if (Array.isArray(response)) {
              select.innerHTML = '<option value="">Select Category</option>';
              response.forEach(function (category) {
                const option = document.createElement("option");
                option.value = category.id;
                option.textContent = category.name;
                select.appendChild(option);
              });
            }
          }
        );
      },
    };
  }

  // Create global object to store all entity managers
  window.adminApp = {
    // Entity managers
    blogs: null,
    events: null,
    services: null,
    categories: null,
    contacts: null,

    // Initialize specific page functionality
    initPage: function (pageType) {
      console.log(`Initializing ${pageType} page...`);

      switch (pageType) {
        case "blogs":
          this.blogs = createEntityManager(
            "blogs",
            "blogTableBody",
            "blogModal",
            "blogForm"
          );
          this.setupFormHandler("blogForm", "blogs");
          this.blogs.fetch();
          // Load blog categories into dropdown
          this.blogs.loadCategories("blog", "category_id");
          break;

        case "events":
          this.events = createEntityManager(
            "events",
            "eventTableBody",
            "eventModal",
            "eventForm"
          );
          this.setupFormHandler("eventForm", "events");
          this.events.fetch();
          // Load event categories into dropdown
          this.events.loadCategories("event", "category_id");
          break;

        case "services":
          this.services = createEntityManager(
            "services",
            "serviceTableBody",
            "serviceModal",
            "serviceForm"
          );
          this.setupFormHandler("serviceForm", "services");
          this.services.fetch();
          // Load service categories into dropdown
          this.services.loadCategories("service", "category_id");
          break;

        case "categories":
          this.categories = createEntityManager(
            "categories",
            "categoryTableBody",
            "categoryModal",
            "categoryForm"
          );
          this.setupFormHandler("categoryForm", "categories");
          this.categories.fetch();
          break;

        case "contact":
          this.contacts = createEntityManager(
            "contact_submissions",
            "contactTableBody",
            null,
            null
          );
          this.contacts.fetch();
          break;

        case "add_admin":
          // No initialization needed as the registration form handler is already set up
          console.log("Admin registration page initialized");
          break;

        default:
          console.log(`Page type '${pageType}' not recognized`);
      }
    },

    // Helper function to set up form submission handlers
    setupFormHandler: function (formId, entityType) {
      const form = document.getElementById(formId);
      if (form) {
        form.addEventListener("submit", function (e) {
          e.preventDefault();
          window.adminApp[entityType].post();
        });
      }
    },
  };

  // Setup global accessors for backward compatibility
  window.blogs = {
    fetch: function () {
      if (window.adminApp.blogs) window.adminApp.blogs.fetch();
    },
    post: function () {
      if (window.adminApp.blogs) window.adminApp.blogs.post();
    },
    edit: function (item) {
      if (window.adminApp.blogs) window.adminApp.blogs.edit(item);
    },
    delete: function (id) {
      if (window.adminApp.blogs) window.adminApp.blogs.delete(id);
    },
  };

  window.events = {
    fetch: function () {
      if (window.adminApp.events) window.adminApp.events.fetch();
    },
    post: function () {
      if (window.adminApp.events) window.adminApp.events.post();
    },
    edit: function (item) {
      if (window.adminApp.events) window.adminApp.events.edit(item);
    },
    delete: function (id) {
      if (window.adminApp.events) window.adminApp.events.delete(id);
    },
  };

  window.services = {
    fetch: function () {
      if (window.adminApp.services) window.adminApp.services.fetch();
    },
    post: function () {
      if (window.adminApp.services) window.adminApp.services.post();
    },
    edit: function (item) {
      if (window.adminApp.services) window.adminApp.services.edit(item);
    },
    delete: function (id) {
      if (window.adminApp.services) window.adminApp.services.delete(id);
    },
  };

  window.categories = {
    fetch: function () {
      if (window.adminApp.categories) window.adminApp.categories.fetch();
    },
    post: function () {
      if (window.adminApp.categories) window.adminApp.categories.post();
    },
    edit: function (item) {
      if (window.adminApp.categories) window.adminApp.categories.edit(item);
    },
    delete: function (id) {
      if (window.adminApp.categories) window.adminApp.categories.delete(id);
    },
  };

  window.contacts = {
    fetch: function () {
      if (window.adminApp.contacts) window.adminApp.contacts.fetch();
    },
  };

  // Check for page-specific initialization script tag
  const initScript = document.getElementById("init-admin-page");
  if (initScript && initScript.getAttribute("data-page")) {
    const pageType = initScript.getAttribute("data-page");
    window.adminApp.initPage(pageType);

    // Also initialize our utility functions based on the page type
    if (window.adminUtils && typeof window.adminUtils.initPage === "function") {
      window.adminUtils.initPage(pageType);
    }
  }

  // Call setup function when DOM is loaded
  window.adminUtils.setupImagePreviews();
});
