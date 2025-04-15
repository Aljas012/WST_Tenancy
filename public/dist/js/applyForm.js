var tenantStoreRoute = window.routes.tenantApplicationStore;

document
    .getElementById("tenantButton")
    .addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default anchor behavior

        // Change the content of hero-copy
        var heroCopy = document.querySelector(".hero-copy");

        // Create a form dynamically
        var form = document.createElement("form");
        form.classList.add("tenant-form"); // Add the custom form class
        form.method = "POST"; // Set method to POST
        form.action = tenantStoreRoute;

        // Get the CSRF token from the meta tag and create a hidden input
        var csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        var csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = "_token";
        csrfInput.value = csrfToken;

        // Append CSRF token to the form
        form.appendChild(csrfInput);

        // Create the heading
        var heading = document.createElement("h4");
        heading.textContent = "Tenancy Application Form";
        heading.style.marginTop = "0"; // optional styling

        // Create the "Full Name" input
        var fullNameInput = document.createElement("input");
        fullNameInput.type = "text";
        fullNameInput.className = "form-control";
        fullNameInput.placeholder = "Full Name";
        fullNameInput.name = "full_name";
        fullNameInput.required = true;

        // Prevent numbers/symbols in real-time
        fullNameInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z\s.]/g, ""); // This will allow letters, spaces, and dots
        });

        // Create the "Email Address" input
        var emailInput = document.createElement("input");
        emailInput.type = "email";
        emailInput.className = "form-control";
        emailInput.placeholder = "Email Address";
        emailInput.name = "email"; // Add name attribute
        emailInput.required = true;

        // Create the "Contact" input
        var contactInput = document.createElement("input");
        contactInput.type = "tel";
        contactInput.className = "form-control";
        contactInput.name = "contact";
        contactInput.placeholder = "Phone Number";
        contactInput.required = true;
        contactInput.pattern = "[0-9]{10,11}"; // for submit-time validation
        contactInput.setAttribute("maxlength", "11");
        contactInput.autocomplete = "tel";

        // Real-time letter blocking
        contactInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "");
        });

        // Create the "TypeOfBusiness" input
        var typeOfBusinessInput = document.createElement("input");
        typeOfBusinessInput.type = "text";
        typeOfBusinessInput.className = "form-control";
        typeOfBusinessInput.placeholder = "Type of Business";
        typeOfBusinessInput.name = "business";
        typeOfBusinessInput.required = true;

        // Prevent numbers/symbols in real-time
        typeOfBusinessInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
        });

        // Create the "Domain" input
        var domainInput = document.createElement("input");
        domainInput.type = "text";
        domainInput.className = "form-control";
        domainInput.placeholder = "Website Domain";
        domainInput.name = "domain"; // Add name attribute
        domainInput.required = true;

        // Prevent numbers/symbols in real-time
        domainInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
        });

        // Create the "Subscription Choice" dropdown
        var subscriptionSelect = document.createElement("select");
        subscriptionSelect.className = "form-control";
        subscriptionSelect.name = "subscription"; // Add name attribute
        subscriptionSelect.required = true;

        // Create the "Free" option
        var freeOption = document.createElement("option");
        freeOption.value = "Free";
        freeOption.textContent = "Free Subscription";

        // Create the "Month" option
        var monthOption = document.createElement("option");
        monthOption.value = "Month";
        monthOption.textContent = "₱ 999 Month Subscription";

        // Create the "Year" option
        var yearOption = document.createElement("option");
        yearOption.value = "Year";
        yearOption.textContent = "₱ 8,391.60 Year Subscription";

        // Append the options to the dropdown
        subscriptionSelect.appendChild(freeOption);
        subscriptionSelect.appendChild(monthOption);
        subscriptionSelect.appendChild(yearOption);

        // Create a submit button
        var submitButton = document.createElement("button");
        submitButton.className = "button button-primary";
        submitButton.type = "submit";
        submitButton.textContent = "Submit";

        // Show loading indicator on form submission
        form.addEventListener("submit", function () {
            submitButton.disabled = true;
            submitButton.innerHTML =
                '<span class="loading-spinner"></span> Submitting...';
        });

        // Append the inputs and submit button to the form
        form.appendChild(heading);

        form.appendChild(fullNameInput);
        form.appendChild(emailInput);
        form.appendChild(contactInput);
        form.appendChild(typeOfBusinessInput);
        form.appendChild(domainInput);
        form.appendChild(subscriptionSelect);
        form.appendChild(submitButton);

        // Clear the current content of hero-copy and append the form
        heroCopy.innerHTML = "";
        heroCopy.appendChild(form);
    });
