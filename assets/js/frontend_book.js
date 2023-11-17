/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2020, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

window.FrontendBook = window.FrontendBook || {};

/**
 * Frontend Book
 *
 * This module contains functions that implement the book appointment page functionality. Once the
 * initialize() method is called the page is fully functional and can serve the appointment booking
 * process.
 *
 * @module FrontendBook
 */
(function (exports) {

    'use strict';

    /**
     * Contains terms and conditions consent.
     *
     * @type {Object}
     */
    var termsAndConditionsConsent;

    /**
     * Contains privacy policy consent.
     *
     * @type {Object}
     */
    var privacyPolicyConsent;

    /**
     * Determines the functionality of the page.
     *
     * @type {Boolean}
     */
    exports.manageMode = false;

    /**
     * This method initializes the book appointment page.
     *
     * @param {Boolean} defaultEventHandlers (OPTIONAL) Determines whether the default
     * event handlers will be bound to the dom elements.
     * @param {Boolean} manageMode (OPTIONAL) Determines whether the customer is going
     * to make  changes to an existing appointment rather than booking a new one.
     */
    exports.initialize = function (defaultEventHandlers, manageMode) {
        defaultEventHandlers = defaultEventHandlers || true;
        manageMode = manageMode || false;

        if (GlobalVariables.displayCookieNotice && window.cookieconsent) {
            cookieconsent.initialise({
                palette: {
                    popup: {
                        background: '#ffffffbd',
                        text: '#666666'
                    },
                    button: {
                        background: '#429a82',
                        text: '#ffffff'
                    }
                },
                content: {
                    message: EALang.website_using_cookies_to_ensure_best_experience,
                    dismiss: 'OK'
                },
            });

            $('.cc-link').replaceWith(
                $('<a/>', {
                    'data-toggle': 'modal',
                    'data-target': '#cookie-notice-modal',
                    'href': '#',
                    'class': 'cc-link',
                    'text': $('.cc-link').text()
                })
            );
        }

        FrontendBook.manageMode = manageMode;

        // Initialize page's components (tooltips, datepickers etc).
        tippy('[data-tippy-content]');

        var weekDayId = GeneralFunctions.getWeekDayId(GlobalVariables.firstWeekday);

        $('#select-date').datepicker({
            dateFormat: 'dd-mm-yy',
            firstDay: weekDayId,
            minDate: 0,
            defaultDate: Date.today(),

            dayNames: [
                EALang.sunday, EALang.monday, EALang.tuesday, EALang.wednesday,
                EALang.thursday, EALang.friday, EALang.saturday],
            dayNamesShort: [EALang.sunday.substr(0, 3), EALang.monday.substr(0, 3),
                EALang.tuesday.substr(0, 3), EALang.wednesday.substr(0, 3),
                EALang.thursday.substr(0, 3), EALang.friday.substr(0, 3),
                EALang.saturday.substr(0, 3)],
            dayNamesMin: [EALang.sunday.substr(0, 2), EALang.monday.substr(0, 2),
                EALang.tuesday.substr(0, 2), EALang.wednesday.substr(0, 2),
                EALang.thursday.substr(0, 2), EALang.friday.substr(0, 2),
                EALang.saturday.substr(0, 2)],
            monthNames: [EALang.january, EALang.february, EALang.march, EALang.april,
                EALang.may, EALang.june, EALang.july, EALang.august, EALang.september,
                EALang.october, EALang.november, EALang.december],
            prevText: EALang.previous,
            nextText: EALang.next,
            currentText: EALang.now,
            closeText: EALang.close,

            onSelect: function (dateText, instance) {
                FrontendBookApi.getAvailableHours($(this).datepicker('getDate').toString('yyyy-MM-dd'));
                FrontendBook.updateConfirmFrame();
            },

            onChangeMonthYear: function (year, month, instance) {
                var currentDate = new Date(year, month - 1, 1);
                FrontendBookApi.getUnavailableDates($('#select-provider').val(), $('#select-service').val(),
                    currentDate.toString('yyyy-MM-dd'));
            }
        });

        $('#select-timezone').val(Intl.DateTimeFormat().resolvedOptions().timeZone);

        // Bind the event handlers (might not be necessary every time we use this class).
        if (defaultEventHandlers) {
            bindEventHandlers();
        }

        // If the manage mode is true, the appointments data should be loaded by default.
        if (FrontendBook.manageMode) {
            applyAppointmentData(GlobalVariables.appointmentData,
                GlobalVariables.providerData, GlobalVariables.customerData);
        } else {
            var $selectProvider = $('#select-provider');
            var $selectService = $('#select-service');

            // Check if a specific service was selected (via URL parameter).
            var selectedServiceId = GeneralFunctions.getUrlParameter(location.href, 'service');

            if (selectedServiceId && $selectService.find('option[value="' + selectedServiceId + '"]').length > 0) {
                $selectService.val(selectedServiceId);
            }

            $selectService.trigger('change'); // Load the available hours.

            // Check if a specific provider was selected.
            var selectedProviderId = GeneralFunctions.getUrlParameter(location.href, 'provider');

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length === 0) {
                // Select a service of this provider in order to make the provider available in the select box.
                for (var index in GlobalVariables.availableProviders) {
                    var provider = GlobalVariables.availableProviders[index];

                    if (provider.id === selectedProviderId && provider.services.length > 0) {
                        $selectService
                            .val(provider.services[0])
                            .trigger('change');
                    }
                }
            }

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length > 0) {
                $selectProvider
                    .val(selectedProviderId)
                    .trigger('change');
            }

        }
    };

    /**
     * This method binds the necessary event handlers for the book appointments page.
     */
    function bindEventHandlers() {
        /**
         * Event: Timezone "Changed"
         */
        $('#select-timezone').on('change', function () {
            var date = $('#select-date').datepicker('getDate');

            if (!date) {
                return;
            }

            FrontendBookApi.getAvailableHours(date.toString('yyyy-MM-dd'));

            FrontendBook.updateConfirmFrame();
        });

        /**
         * Event: Selected Provider "Changed"
         *
         * Whenever the provider changes the available appointment date - time periods must be updated.
         */
        $('#select-provider').on('change', function () {
            FrontendBookApi.getUnavailableDates($(this).val(), $('#select-service').val(),
                $('#select-date').datepicker('getDate').toString('yyyy-MM-dd'));
            FrontendBook.updateConfirmFrame();
        });

        /**
         * Event: Selected Service "Changed"
         *
         * When the user clicks on a service, its available providers should
         * become visible.
         */
        $('#select-service').on('change', function () {
            var serviceId = $('#select-service').val();

            $('#select-provider').empty();

            GlobalVariables.availableProviders.forEach(function (provider) {
                // If the current provider is able to provide the selected service, add him to the list box.
                var canServeService = provider.services.filter(function (providerServiceId) {
                    return Number(providerServiceId) === Number(serviceId);
                }).length > 0;

                if (canServeService) {
                    $('#select-provider').append(new Option(provider.first_name + ' ' + provider.last_name, provider.id));
                }
            });

            // Add the "Any Provider" entry.
            if ($('#select-provider option').length > 1 && GlobalVariables.displayAnyProvider === '1') {
                $('#select-provider').prepend(new Option('- ' + EALang.any_provider + ' -', 'any-provider', true, true));
            }

            FrontendBookApi.getUnavailableDates($('#select-provider').val(), $(this).val(),
                $('#select-date').datepicker('getDate').toString('yyyy-MM-dd'));
            FrontendBook.updateConfirmFrame();
            updateServiceDescription(serviceId);
        });

        /**
         * Event: Next Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "next" button on the book wizard.
         * Some special tasks might be performed, depending the current wizard step.
         */
        $('.button-next').on('click', function () {
            const stepIndex = parseInt($(this).attr('data-step_index'));
            // console.log(stepIndex);

            switch (stepIndex) {
                case 1:
                    if (!validateDocumentRequest()) return;
                    FrontendBook.updateConfirmFrame();
                    break;
                case 2:
                    if ($(this).attr('data-step_index') == '2' && !$('#select-provider').val()) {
                        return;
                    }
                    break;
                case 3:
                    if (!$('.selected-hour').length) {
                        if (!$('#select-hour-prompt').length) {
                            $('<div/>', {
                                'id': 'select-hour-prompt',
                                'class': 'text-danger mb-4',
                                'text': EALang.appointment_hour_missing,
                            }).prependTo('#available-hours');
                        }
                    }
                    break;
                case 4:
                    if (!validateCustomerForm()) return;
                    FrontendBook.updateConfirmFrame();
                    updateConsent('terms-and-conditions');
                    updateConsent('privacy-policy');
                    break;
                case 5:
                    if (!validateIdentityVerificationForm()) return;
                    FrontendBook.updateConfirmFrame();
                    break;
            }

            const nextTabIndex = stepIndex + 1;
            // console.log(nextTabIndex);

            $(this).parents().eq(1).hide('fade', function () {
                $('.active-step').removeClass('active-step');
                $(`#step-${nextTabIndex}`).addClass('active-step');
                $(`#wizard-frame-${nextTabIndex}`).show('fade');
            });
        });

        function updateConsent(type) {
            const consentCheckbox = $(`#accept-to-${type}`);
            if (consentCheckbox.length && consentCheckbox.prop('checked') === true) {
                const newConsent = {
                    first_name: $('#first-name').val(),
                    last_name: $('#last-name').val(),
                    email: $('#email').val(),
                    type: type,
                };
                let currentConsent = type === 'terms-and-conditions' ? termsAndConditionsConsent : privacyPolicyConsent;
                if (JSON.stringify(newConsent) !== JSON.stringify(currentConsent)) {
                    currentConsent = newConsent;
                    FrontendBookApi.saveConsent(currentConsent);
                }
            }
        }


        /**
         * Event: Back Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "back" button on the
         * book wizard.
         */
        $('.button-back').on('click', function () {
            var prevTabIndex = parseInt($(this).attr('data-step_index')) - 1;

            $(this).parents().eq(1).hide('fade', function () {
                $('.active-step').removeClass('active-step');
                $('#step-' + prevTabIndex).addClass('active-step');
                $('#wizard-frame-' + prevTabIndex).show('fade');
            });
        });

        /**
         * Event: Available Hour "Click"
         *
         * Triggered whenever the user clicks on an available hour
         * for his appointment.
         */
        $('#available-hours').on('click', '.available-hour', function () {
            $('.selected-hour').removeClass('selected-hour');
            $(this).addClass('selected-hour');
            FrontendBook.updateConfirmFrame();
        });

        if (FrontendBook.manageMode) {
            /**
             * Event: Cancel Appointment Button "Click"
             *
             * When the user clicks the "Cancel" button this form is going to be submitted. We need
             * the user to confirm this action because once the appointment is cancelled, it will be
             * delete from the database.
             *
             * @param {jQuery.Event} event
             */
            $('#cancel-appointment').on('click', function (event) {
                var buttons = [
                    {
                        text: EALang.cancel,
                        click: function () {
                            $('#message-box').dialog('close');
                        }
                    },
                    {
                        text: 'OK',
                        click: function () {
                            if ($('#cancel-reason').val() === '') {
                                $('#cancel-reason').css('border', '2px solid #DC3545');
                                return;
                            }
                            $('#cancel-appointment-form textarea').val($('#cancel-reason').val());
                            $('#cancel-appointment-form').submit();
                        }
                    }
                ];

                GeneralFunctions.displayMessageBox(EALang.cancel_appointment_title,
                    EALang.write_appointment_removal_reason, buttons);

                $('<textarea/>', {
                    'class': 'form-control',
                    'id': 'cancel-reason',
                    'rows': '3',
                    'css': {
                        'width': '100%'
                    }
                })
                    .appendTo('#message-box');

                return false;
            });

            $('#delete-personal-information').on('click', function () {
                var buttons = [
                    {
                        text: EALang.cancel,
                        click: function () {
                            $('#message-box').dialog('close');
                        }
                    },
                    {
                        text: EALang.delete,
                        click: function () {
                            FrontendBookApi.deletePersonalInformation(GlobalVariables.customerToken);
                        }
                    }
                ];

                GeneralFunctions.displayMessageBox(EALang.delete_personal_information,
                    EALang.delete_personal_information_prompt, buttons);
            });
        }

        /**
         * Event: Book Appointment Form "Submit"
         *
         * Before the form is submitted to the server we need to make sure that
         * in the meantime the selected appointment date/time wasn't reserved by
         * another customer or event.
         *
         * @param {jQuery.Event} event
         */
        $('#book-appointment-submit').on('click', function () {
            FrontendBookApi.registerAppointment();
        });

        /**
         * Event: Refresh captcha image.
         *
         * @param {jQuery.Event} event
         */
        $('.captcha-title button').on('click', function (event) {
            $('.captcha-image').attr('src', GlobalVariables.baseUrl + '/index.php/captcha?' + Date.now());
        });


        $('#select-date').on('mousedown', '.ui-datepicker-calendar td', function (event) {
            setTimeout(function () {
                FrontendBookApi.applyPreviousUnavailableDates(); // New jQuery UI version will replace the td elements.
            }, 300); // There is no draw event unfortunately.
        })
    }

    /**
     * This function validates the customer's data input. The user cannot continue
     * without passing all the validation checks.
     *
     * @return {Boolean} Returns the validation result.
     */
    function validateCustomerForm() {
        var $frame4 = $('#wizard-frame-4');
        $frame4.find('.has-error').removeClass('has-error');
        $frame4.find('label.text-danger').removeClass('text-danger');

        try {
            // Validate required fields within #wizard-frame-4.
            var missingRequiredField = false;
            $frame4.find('.required').each(function (index, requiredField) {
                if (!$(requiredField).val()) {
                    $(requiredField).parents('.form-group').addClass('has-error');
                    missingRequiredField = true;
                }
            });
            if (missingRequiredField) {
                throw new Error(EALang.fields_are_required);
            }

            var $acceptToTermsAndConditions = $frame4.find('#accept-to-terms-and-conditions');
            if ($acceptToTermsAndConditions.length && !$acceptToTermsAndConditions.prop('checked')) {
                $acceptToTermsAndConditions.parents('.form-check').addClass('text-danger');
                throw new Error(EALang.fields_are_required);
            }

            var $acceptToPrivacyPolicy = $frame4.find('#accept-to-privacy-policy');
            if ($acceptToPrivacyPolicy.length && !$acceptToPrivacyPolicy.prop('checked')) {
                $acceptToPrivacyPolicy.parents('.form-check').addClass('text-danger');
                throw new Error(EALang.fields_are_required);
            }

            // Validate email address within #wizard-frame-4.
            if (!GeneralFunctions.validateEmail($frame4.find('#email').val())) {
                $frame4.find('#email').parents('.form-group').addClass('has-error');
                throw new Error(EALang.invalid_email);
            }

            return true;
        } catch (error) {
            $('#form-message').text(error.message);
            return false;
        }
    }

    /**
     * This function validates the identity verification's data input. The user cannot continue
     * without passing all the validation checks.
     *
     * @return {Boolean} Returns the validation result.
     */
    function validateIdentityVerificationForm() {
        var $frame5 = $('#wizard-frame-5');
        $frame5.find('.has-error').removeClass('has-error');
        $frame5.find('label.text-danger').removeClass('text-danger');

        try {
            // Validate required fields within #wizard-frame-5.
            var missingRequiredField = false;
            $frame5.find('.required').each(function (index, requiredField) {
                if (!$(requiredField).val()) {
                    $(requiredField).parents('.form-group').addClass('has-error');
                    missingRequiredField = true;
                }
            });
            if (missingRequiredField) {
                throw new Error(EALang.fields_are_required);
            }


            return true;
        } catch (error) {
            $('#form-message').text(error.message);
            return false;
        }
    }

    function validateDocumentRequest() {
        var $frame1 = $('#wizard-frame-1');
        $frame1.find('.has-error').removeClass('has-error');
        $frame1.find('label.text-danger').removeClass('text-danger');

        try {
            // Validate required fields within #wizard-frame-1.
            var missingRequiredField = false;
            $frame1.find('.required').each(function (index, requiredField) {
                if (!$(requiredField).val()) {
                    $(requiredField).parents('.form-group').addClass('has-error');
                    missingRequiredField = true;
                }
            });

            if (missingRequiredField) {
                throw new Error(EALang.fields_are_required);
            }

            return true;
        } catch (error) {
            $('#form-message').text(error.message);
            return false;
        }
    }
    /**
     * Every time this function is executed, it updates the confirmation page with the latest
     * customer settings and input for the appointment booking.
     */
    exports.updateConfirmFrame = function () {
        if ($('.selected-hour').text() === '') {
            return;
        }

        // Appointment Details
        var selectedDate = $('#select-date').datepicker('getDate');

        if (selectedDate !== null) {
            selectedDate = GeneralFunctions.formatDate(selectedDate, GlobalVariables.dateFormat);
        }

        var serviceId = $('#select-service').val();
        var servicePrice = '';
        var serviceCurrency = '';

        GlobalVariables.availableServices.forEach(function (service, index) {
            if (Number(service.id) === Number(serviceId) && Number(service.price) > 0) {
                servicePrice = service.price;
                serviceCurrency = service.currency;
                return false; // break loop
            }
        });

        $('#appointment-details').empty();

        $('<div/>', {
            'html': [
                $('<h4/>', {
                    'text': EALang.appointment
                }),
                $('<p/>', {
                    'html': [
                        $('<span/>', {
                            'text': EALang.service + ': ' + $('#select-service option:selected').text()
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': EALang.provider + ': ' + $('#select-provider option:selected').text()
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': EALang.start + ': ' + selectedDate + ' ' + $('.selected-hour').text()
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': EALang.timezone + ': ' + $('#select-timezone option:selected').text()
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': EALang.price + ': ' + servicePrice + ' ' + serviceCurrency,
                            'prop': {
                                'hidden': !servicePrice
                            }
                        }),
                    ]
                })
            ]
        }).appendTo('#appointment-details');

        // Customer Details
        var firstName = GeneralFunctions.escapeHtml($('#first-name').val());
        var lastName = GeneralFunctions.escapeHtml($('#last-name').val());
        var phoneNumber = GeneralFunctions.escapeHtml($('#phone-number').val());
        var email = GeneralFunctions.escapeHtml($('#email').val());
        var address = GeneralFunctions.escapeHtml($('#address').val());
        var city = GeneralFunctions.escapeHtml($('#city').val());
        var zipCode = GeneralFunctions.escapeHtml($('#zip-code').val());
        var dateOfBirth =  GeneralFunctions.escapeHtml($('#date-of-birth').val());
        var motherMaidenName =  GeneralFunctions.escapeHtml($('#mother-maiden-name').val());
        var programGraduatedEnrolled =  GeneralFunctions.escapeHtml($('#program-graduated-enrolled').val());
        var yearGraduate =  GeneralFunctions.escapeHtml($('#year-graduate').val());
        var nameOfSchool =  GeneralFunctions.escapeHtml($('#name-of-school-honorable-dismissal-only').val());
        var fileInputHere = GeneralFunctions.escapeHtml($('#fileInputHere').val());
        var selectedDocument = GeneralFunctions.escapeHtml($('#select-document').val());

        $('#selected-document-details').empty();
        $('<div/>', {
            'html': [
                $('<h4/>)', {
                    'text': 'Document Request'
                }),
                $('<p/>', {
                    'html': [
                        $('<span/>', {
                            'text': 'Document Requested: ' + selectedDocument
                        }),
                    ]
                })
            ]
        }).appendTo('#selected-document-details');

        $('#customer-details').empty();
        $('<div/>', {
            'html': [
                $('<h4/>)', {
                    'text': EALang.customer
                }),
                $('<p/>', {
                    'html': [
                        $('<span/>', {
                            'text': EALang.customer + ': ' + firstName + ' ' + lastName
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': EALang.phone_number + ': ' + phoneNumber
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': EALang.email + ': ' + email
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': address ? EALang.address + ': ' + address : ''
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': city ? EALang.city + ': ' + city : ''
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': zipCode ? EALang.zip_code + ': ' + zipCode : ''
                        }),
                        $('<br/>'),
                    ]
                })
            ]
        }).appendTo('#customer-details');

        $('#identity-verification-details').empty();

        $('<div/>', {
            'html': [
                $('<h4/>', {
                    'text': 'Identity Verification'
                }),
                $('<p/>', {
                    'html': [
                        $('<span/>', {
                            'text': 'Date of Birth: ' + dateOfBirth
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': "Mother's Maiden Name: " + motherMaidenName
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': 'Program Graduated/Enrolled: ' + programGraduatedEnrolled
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': 'Year Graduate: ' + yearGraduate
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': 'Name of School (for honorable dismissal only): ' + nameOfSchool
                        }),
                        $('<br/>'),
                        $('<span/>', {
                            'text': 'Picture Copy of your Student ID or valid ID (back to back):'
                        }),
                    ]
                })
            ]
        }).appendTo('#identity-verification-details');




        // Update appointment form data for submission to server when the user confirms the appointment.
        var data = {};
        // Add an event listener to the file input element
        function generateUniqueFilename(originalFilename) {
            // Generate a unique filename by adding a timestamp or using a UUID.
            var timestamp = new Date().getTime();
            return timestamp + '_' + originalFilename;
        }

        document.getElementById('valid-id fileInput').addEventListener('change', function () {
            getFileInputImagePreview();
        });

        function getFileInputImagePreview() {
            var imagePreview = document.getElementById('imagePreview');
            var fileInput = document.querySelector('.valid-id-fileInput');
            var formData = new FormData();
            var renamedFiles = []; // Array to store renamed file information

            // Clear the previous image previews
            imagePreview.innerHTML = '';

            for (var i = 0; i < fileInput.files.length; i++) {
                var file = fileInput.files[i];

                // Create a unique name using a timestamp and a random number
                var timestamp = new Date().getTime();
                var random = Math.floor(Math.random() * 1000);
                var uniqueName = timestamp + '_' + random + '_' + file.name;

                renamedFiles.push({ originalName: file.name, uniqueName: uniqueName });

                formData.append('fileInput[]', file, uniqueName);

                var image = URL.createObjectURL(file);
                var newImage = document.createElement('img');

                newImage.src = image;
                newImage.style.width = '150px';
                newImage.style.height = '150px';

                imagePreview.appendChild(newImage);
            }

            // Send the files to the server using the fetch API
            fetch('./uploads/upload.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(result => {
                    // Handle the response from the server if needed
                    // console.log('Server response:', result);

                    // Add the renamed files to the renamedFiles variable
                    var uploadedValidIds = renamedFiles.map(function(file) {
                        return file.uniqueName;
                    });

                    //console.log("uploadedValidIds: " + uploadedValidIds);

                    // Store uploadedValidIds in localStorage
                    // Check if uploadedValidIds already exist in localStorage
                    var existingUploadedValidIds = JSON.parse(localStorage.getItem('uploadedValidIds'));

                    // Update the localStorage entry for uploadedValidIds
                    if (existingUploadedValidIds && existingUploadedValidIds.length > 0) {
                        localStorage.removeItem('uploadedValidIds'); // Clear existing entry
                    }

                    // Set the new uploadedValidIds in localStorage
                    localStorage.setItem('uploadedValidIds', JSON.stringify(uploadedValidIds));

                    updateCustomerData(uploadedValidIds);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Retrieve uploadedValidIds from localStorage
        var uploadedValidIds = JSON.parse(localStorage.getItem('uploadedValidIds')) ?? "";
        function updateCustomerData(uploadedValidIds) {
            return uploadedValidIds;
            // console.log("Customer Data:", data.customer);
        }
        data.customer = {
            last_name: $('#last-name').val(),
            first_name: $('#first-name').val(),
            email: $('#email').val(),
            phone_number: $('#phone-number').val(),
            address: $('#address').val(),
            city: $('#city').val(),
            zip_code: $('#zip-code').val(),
            timezone: $('#select-timezone').val(),
            dateOfBirth: $('#date-of-birth').val(),
            motherMaidenName: $('#mother-maiden-name').val(),
            programGraduatedEnrolled: $('#program-graduated-enrolled').val(),
            yearGraduate: $('#year-graduate').val(),
            nameOfSchool: $('#name-of-school-honorable-dismissal-only').val(),
            document_requested: $('#select-document').val(),
            uploaded_valid_id: uploadedValidIds.toString(),
        }


        data.appointment = {
            start_datetime: $('#select-date').datepicker('getDate').toString('yyyy-MM-dd')
                + ' ' + Date.parse($('.selected-hour').data('value') || '').toString('HH:mm') + ':00',
            end_datetime: calculateEndDatetime(),
            notes: $('#notes').val(),
            is_unavailable: false,
            id_users_provider: $('#select-provider').val(),
            id_services: $('#select-service').val()
        };

        data.manage_mode = FrontendBook.manageMode;

        if (FrontendBook.manageMode) {
            data.appointment.id = GlobalVariables.appointmentData.id;
            data.customer.id = GlobalVariables.customerData.id;
        }
        $('input[name="csrfToken"]').val(GlobalVariables.csrfToken);
        $('input[name="post_data"]').val(JSON.stringify(data));
    };

    /**
     * This method calculates the end datetime of the current appointment.
     * End datetime is depending on the service and start datetime fields.
     *
     * @return {String} Returns the end datetime in string format.
     */
    function calculateEndDatetime() {
        // Find selected service duration.
        var serviceId = $('#select-service').val();

        var service = GlobalVariables.availableServices.find(function (availableService) {
            return Number(availableService.id) === Number(serviceId);
        });

        // Add the duration to the start datetime.
        var startDatetime = $('#select-date').datepicker('getDate').toString('dd-MM-yyyy')
            + ' ' + Date.parse($('.selected-hour').data('value') || '').toString('HH:mm');
        startDatetime = Date.parseExact(startDatetime, 'dd-MM-yyyy HH:mm');
        var endDatetime;

        if (service.duration && startDatetime) {
            endDatetime = startDatetime.add({'minutes': parseInt(service.duration)});
        } else {
            endDatetime = new Date();
        }

        return endDatetime.toString('yyyy-MM-dd HH:mm:ss');
    }

    /**
     * This method applies the appointment's data to the wizard so
     * that the user can start making changes on an existing record.
     *
     * @param {Object} appointment Selected appointment's data.
     * @param {Object} provider Selected provider's data.
     * @param {Object} customer Selected customer's data.
     *
     * @return {Boolean} Returns the operation result.
     */
    function applyAppointmentData(appointment, provider, customer) {
        try {
            // Select Service & Provider
            $('#select-service').val(appointment.id_services).trigger('change');
            $('#select-provider').val(appointment.id_users_provider);

            // Set Appointment Date
            $('#select-date').datepicker('setDate',
                Date.parseExact(appointment.start_datetime, 'yyyy-MM-dd HH:mm:ss'));
            FrontendBookApi.getAvailableHours(moment(appointment.start_datetime).format('YYYY-MM-DD'));

            // Apply Customer's Data
            $('#last-name').val(customer.last_name);
            $('#first-name').val(customer.first_name);
            $('#email').val(customer.email);
            $('#phone-number').val(customer.phone_number);
            $('#address').val(customer.address);
            $('#city').val(customer.city);
            $('#zip-code').val(customer.zip_code);
            if (customer.timezone) {
                $('#select-timezone').val(customer.timezone)
            }
            var appointmentNotes = (appointment.notes !== null)
                ? appointment.notes : '';
            $('#notes').val(appointmentNotes);
            $('#date-of-birth').val(customer.dateOfBirth);
            $('#mother-maiden-name').val(customer.motherMaidenName);
            $('#program-graduated-enrolled').val(customer.programGraduatedEnrolled);
            $('#year-graduate').val(customer.yearGraduate);
            $('#name-of-school-honorable-dismissal-only').val(customer.nameOfSchool);
            $('#select-document').val(customer.nameOfSchool);
            $('#fileInputHere').val(customer.uploaded_valid_id);

            FrontendBook.updateConfirmFrame();

            return true;
        } catch (exc) {
            return false;
        }
    }

    /**
     * This method updates a div's html content with a brief description of the
     * user selected service (only if available in db). This is useful for the
     * customers upon selecting the correct service.
     *
     * @param {Number} serviceId The selected service record id.
     */
    function updateServiceDescription(serviceId) {
        var $serviceDescription = $('#service-description');

        $serviceDescription.empty();

        var service = GlobalVariables.availableServices.find(function (availableService) {
            return Number(availableService.id) === Number(serviceId);
        });

        if (!service) {
            return;
        }

        $('<strong/>', {
            'text': service.name
        })
            .appendTo($serviceDescription);

        if (service.description) {
            $('<br/>')
                .appendTo($serviceDescription);

            $('<span/>', {
                'html': GeneralFunctions.escapeHtml(service.description).replaceAll('\n', '<br/>')
            })
                .appendTo($serviceDescription);
        }

        if (service.duration || Number(service.price) > 0 || service.location) {
            $('<br/>')
                .appendTo($serviceDescription);
        }

        if (service.duration) {
            $('<span/>', {
                'text': '[' + EALang.duration + ' ' + service.duration + ' ' + EALang.minutes + ']'
            })
                .appendTo($serviceDescription);
        }

        if (Number(service.price) > 0) {
            $('<span/>', {
                'text': '[' + EALang.price + ' ' + service.price + ' ' + service.currency + ']'
            })
                .appendTo($serviceDescription);
        }

        if (service.location) {
            $('<span/>', {
                'text': '[' + EALang.location + ' ' + service.location + ']'
            })
                .appendTo($serviceDescription);
        }
    }

})(window.FrontendBook);
