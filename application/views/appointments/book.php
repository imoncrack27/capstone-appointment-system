<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#35A768">

    <title><?= lang('page_title') . ' ' . $company_name ?></title>

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/jquery-ui/jquery-ui.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/cookieconsent/cookieconsent.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/frontend.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">

    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">

    <script src="<?= asset_url('assets/ext/fontawesome/js/fontawesome.min.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/fontawesome/js/solid.min.js') ?>"></script>
</head>

<body>
<div id="main" class="container">
    <div class="row wrapper">
        <div id="book-appointment-wizard" class="col-12 col-lg-10 col-xl-8">

            <!-- FRAME TOP BAR -->

            <div id="header">
                <span id="company-name"><?= $company_name ?></span>

                <div id="steps">
                    <div id="step-1" class="book-step active-step"
                         data-tippy-content="<?= lang('document_request') ?>">
                        <strong>1</strong>
                    </div>

                    <div id="step-2" class="book-step"
                         data-tippy-content="<?= lang('service_and_provider') ?>">
                        <strong>2</strong>
                    </div>

                    <div id="step-3" class="book-step" data-toggle="tooltip"
                         data-tippy-content="<?= lang('appointment_date_and_time') ?>">
                        <strong>3</strong>
                    </div>
                    <div id="step-4" class="book-step" data-toggle="tooltip"
                         data-tippy-content="<?= lang('customer_information') ?>">
                        <strong>4</strong>
                    </div>
                    <div id="step-5" class="book-step" data-toggle="tooltip"
                         data-tippy-content="<?= lang('identity_verification') ?>">
                        <strong>5</strong>
                    </div>
                    <div id="step-6" class="book-step" data-toggle="tooltip"
                         data-tippy-content="<?= lang('appointment_confirmation') ?>">
                        <strong>6</strong>
                    </div>
                </div>
            </div>

            <?php if ($manage_mode): ?>
                <div id="cancel-appointment-frame" class="row booking-header-bar">
                    <div class="col-12 col-md-10">
                        <small><?= lang('cancel_appointment_hint') ?></small>
                    </div>
                    <div class="col-12 col-md-2">
                        <form id="cancel-appointment-form" method="post"
                              action="<?= site_url('appointments/cancel/' . $appointment_data['hash']) ?>">

                            <input type="hidden" name="csrfToken" value="<?= $this->security->get_csrf_hash() ?>"/>

                            <textarea name="cancel_reason" style="display:block"></textarea>

                            <button id="cancel-appointment" class="btn btn-warning btn-sm">
                                <?= lang('cancel') ?>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="booking-header-bar row">
                    <div class="col-12 col-md-10">
                        <small><?= lang('delete_personal_information_hint') ?></small>
                    </div>
                    <div class="col-12 col-md-2">
                        <button id="delete-personal-information"
                                class="btn btn-danger btn-sm"><?= lang('delete') ?></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($exceptions)): ?>
                <div style="margin: 10px">
                    <h4><?= lang('unexpected_issues') ?></h4>

                    <?php foreach ($exceptions as $exception): ?>
                        <?= exceptionToHtml($exception) ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <div id="wizard-frame-1" class="wizard-frame">
                <div class="frame-container">
                    <h2 class="frame-title"><?= lang('document_request') ?></h2>

                    <div class="row frame-content">
                        <div class="col">
                            <div class="form-group">
                                <label for="select-document" class="control-label">
                                    <strong>Document</strong>
                                    <span class="text-danger">*</span>
                                </label>
                                <!-- Button trigger modal -->
                                <select id="select-document" class="required form-control">
                                    <option value="" selected disabled>Document</option>
                                    <option value="Diploma [Baccalaurate]">Diploma [Baccalaurate]</option>
                                    <option value="Diploma [Masteral]">Diploma [Masteral]</option>
                                    <option value="Diploma [PhD]">Diploma [PhD]</option>
                                    <option value="English as medium of Instructions">English as medium of Instructions</option>
                                    <option value="Enrollment/Grades">Enrollment/Grades</option>
                                    <option value="Other Transactions">Other Transactions</option>
                                    <option value="PAASCU for Accredited programs">PAASCU for Accredited programs</option>
                                    <option value="Related Learning Experience">Related Learning Experience</option>
                                    <option value="Special Order">Special Order</option>
                                    <option value="Academic Completion">Academic Completion</option>
                                    <option value="Authenticity">Authenticity</option>
                                    <option value="Candidacy for Graduation">Candidacy for Graduation</option>
                                    <option value="CAV[Certification, Authentication, Va...]">CAV[Certification, Authentication, Va...]</option>
                                    <option value="Certified True Copy">Certified True Copy</option>
                                    <option value="Computer Literacy">Computer Literacy</option>
                                    <option value="Correction of Name">Correction of Name</option>
                                    <option value="Correction of Program Major">Correction of Program Major</option>
                                    <option value="Cumulative GPA">Cumulative GPA</option>
                                    <option value="Special Study Permit">Special Study Permit</option>
                                    <option value="TOR[Board Exam Purposes]">TOR[Board Exam Purposes]</option>
                                    <option value="TOR[Evaluation Purposes]">TOR[Evaluation Purposes]</option>
                                    <option value="Transfer credential">Transfer credential</option>
                                    <option value="Units Earned">Units Earned</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Reminders</h5>
                            </div>
                            <div class="modal-body">
                                <p>1. Appointment date DOES NOT necessarily mean we will release your document(s) on that same day.</p>
                                <p>2. You do not need to come to LSU. We will call you on your appointment date/time.</p>
                                <p>3. We can send you requested documents to your address through a courier or you may claim it personally in the office during the release date.</p>
                                <p> Claim of documents by representative should provide the following: </p>
                                <ul>
                                    <li style="font-style: italic; font-size: 14px;">Special Power of Attorney (SPA) or Notarized Authorization Letter.</li>
                                    <li style="font-style: italic; font-size: 14px;">Photocopy of any one (1) valid ID (preferably Government ID) of the representative and the owner.</li>
                                    <li style="font-style: italic; font-size: 14px;">Copy of Claim Stub.</li>
                                </ul>
                                <div class="form-group form-check" >
                                    <div style="display: flex; align-items: center; gap: .5rem; flex-direction: row-reverse; justify-content: flex-end;">
                                        <label for="checkbox" class="control-label form-check-label" style="font-size: 15px; margin-top: 1.5%;">
                                            Please check to confirm that they have agreed/understood the following reminders
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="checkbox" class="required form-control form-check" id="checkbox" style="width: 5%; margin-left: -15px;"  />

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="is_checked_btn" data-dismiss="modal" disabled>Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="command-buttons">
                    <span>&nbsp;</span>

                    <button type="button" id="button-next-1" class="btn button-next btn-dark"
                            data-step_index="1">
                        <?= lang('next') ?>
                        <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </div>
            <!-- SELECT SERVICE AND PROVIDER -->

            <div id="wizard-frame-2" class="wizard-frame" style="display:none;">
                <div class="frame-container">
                    <h2 class="frame-title"><?= lang('service_and_provider') ?></h2>

                    <div class="row frame-content">
                        <div class="col">
                            <div class="form-group">
                                <label for="select-service">
                                    <strong><?= lang('service') ?></strong>
                                </label>

                                <select id="select-service" class="form-control">
                                    <?php
                                    // Group services by category, only if there is at least one service with a parent category.
                                    $has_category = FALSE;
                                    foreach ($available_services as $service)
                                    {
                                        if ($service['category_id'] != NULL)
                                        {
                                            $has_category = TRUE;
                                            break;
                                        }
                                    }

                                    if ($has_category)
                                    {
                                        $grouped_services = [];

                                        foreach ($available_services as $service)
                                        {
                                            if ($service['category_id'] != NULL)
                                            {
                                                if ( ! isset($grouped_services[$service['category_name']]))
                                                {
                                                    $grouped_services[$service['category_name']] = [];
                                                }

                                                $grouped_services[$service['category_name']][] = $service;
                                            }
                                        }

                                        // We need the uncategorized services at the end of the list so we will use
                                        // another iteration only for the uncategorized services.
                                        $grouped_services['uncategorized'] = [];
                                        foreach ($available_services as $service)
                                        {
                                            if ($service['category_id'] == NULL)
                                            {
                                                $grouped_services['uncategorized'][] = $service;
                                            }
                                        }

                                        foreach ($grouped_services as $key => $group)
                                        {
                                            $group_label = ($key != 'uncategorized')
                                                ? $group[0]['category_name'] : 'Uncategorized';

                                            if (count($group) > 0)
                                            {
                                                echo '<optgroup label="' . $group_label . '">';
                                                foreach ($group as $service)
                                                {
                                                    echo '<option value="' . $service['id'] . '">'
                                                        . $service['name'] . '</option>';
                                                }
                                                echo '</optgroup>';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        foreach ($available_services as $service)
                                        {
                                            echo '<option value="' . $service['id'] . '">' . $service['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="select-provider">
                                    <strong><?= lang('provider') ?></strong>
                                </label>

                                <select id="select-provider" class="form-control"></select>
                            </div>

                            <div id="service-description"></div>
                        </div>
                    </div>
                </div>

                <div class="command-buttons">
                    <button type="button" id="button-back-2" class="btn button-back btn-outline-secondary"
                            data-step_index="2">
                        <i class="fas fa-chevron-left mr-2"></i>
                        <?= lang('back') ?>
                    </button>
                    <button type="button" id="button-next-2" class="btn button-next btn-dark"
                            data-step_index="2">
                        <?= lang('next') ?>
                        <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- SELECT APPOINTMENT DATE -->

            <div id="wizard-frame-3" class="wizard-frame" style="display:none;">
                <div class="frame-container">

                    <h2 class="frame-title"><?= lang('appointment_date_and_time') ?></h2>

                    <div class="row frame-content">
                        <div class="col-12 col-md-6">
                            <div id="select-date"></div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div id="select-time">
                                <div class="form-group">
                                    <label for="select-timezone"><?= lang('timezone') ?></label>
                                    <?= render_timezone_dropdown('id="select-timezone" class="form-control" value="UTC"'); ?>
                                </div>

                                <div id="available-hours"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="command-buttons">
                    <button type="button" id="button-back-3" class="btn button-back btn-outline-secondary"
                            data-step_index="3">
                        <i class="fas fa-chevron-left mr-2"></i>
                        <?= lang('back') ?>
                    </button>
                    <button type="button" id="button-next-4" class="btn button-next btn-dark"
                            data-step_index="3">
                        <?= lang('next') ?>
                        <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- ENTER CUSTOMER DATA -->

            <div id="wizard-frame-4" class="wizard-frame" style="display:none;">
                <div class="frame-container">

                    <h2 class="frame-title"><?= lang('customer_information') ?></h2>

                    <div class="row frame-content">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="first-name" class="control-label">
                                    <?= lang('first_name') ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="first-name" class="required form-control" maxlength="100"/>
                            </div>
                            <div class="form-group">
                                <label for="last-name" class="control-label">
                                    <?= lang('last_name') ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="last-name" class="required form-control" maxlength="120"/>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">
                                    <?= lang('email') ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="email" class="required form-control" maxlength="120"/>
                            </div>
                            <div class="form-group">
                                <label for="phone-number" class="control-label">
                                    <?= lang('phone_number') ?>
                                    <?= $require_phone_number === '1' ? '<span class="text-danger">*</span>' : '' ?>
                                </label>
                                <input type="text" id="phone-number" maxlength="60"
                                       class="<?= $require_phone_number === '1' ? 'required' : '' ?> form-control"/>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="address" class="control-label">
                                    <?= lang('address') ?>
                                </label>
                                <input type="text" id="address" class="form-control" maxlength="120"/>
                            </div>
                            <div class="form-group">
                                <label for="city" class="control-label">
                                    <?= lang('city') ?>
                                </label>
                                <input type="text" id="city" class="form-control" maxlength="120"/>
                            </div>
                            <div class="form-group">
                                <label for="zip-code" class="control-label">
                                    <?= lang('zip_code') ?>
                                </label>
                                <input type="text" id="zip-code" class="form-control" maxlength="120"/>
                            </div>
                            <div class="form-group">
                                <label for="notes" class="control-label">
                                    <?= lang('notes') ?>
                                </label>
                                <textarea id="notes" maxlength="500" class="form-control" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($display_terms_and_conditions): ?>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="required form-check-input" id="accept-to-terms-and-conditions">
                        <label class="form-check-label" for="accept-to-terms-and-conditions">
                            <?= strtr(lang('read_and_agree_to_terms_and_conditions'),
                                [
                                    '{$link}' => '<a href="#" data-toggle="modal" data-target="#terms-and-conditions-modal">',
                                    '{/$link}' => '</a>'
                                ])
                            ?>
                        </label>
                    </div>
                <?php endif ?>

                <?php if ($display_privacy_policy): ?>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="required form-check-input" id="accept-to-privacy-policy">
                        <label class="form-check-label" for="accept-to-privacy-policy">
                            <?= strtr(lang('read_and_agree_to_privacy_policy'),
                                [
                                    '{$link}' => '<a href="#" data-toggle="modal" data-target="#privacy-policy-modal">',
                                    '{/$link}' => '</a>'
                                ])
                            ?>
                        </label>
                    </div>
                <?php endif ?>

                <div class="command-buttons">
                    <button type="button" id="button-back-4" class="btn button-back btn-outline-secondary"
                            data-step_index="4">
                        <i class="fas fa-chevron-left mr-2"></i>
                        <?= lang('back') ?>
                    </button>
                    <button type="button" id="button-next-4" class="btn button-next btn-dark"
                            data-step_index="4">
                        <?= lang('next') ?>
                        <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </div>

            <div id="wizard-frame-5" class="wizard-frame" style="display:none;">
                <div class="frame-container">

                    <h2 class="frame-title"><?= lang('identity_verification') ?></h2>

                    <div class="row frame-content">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="date-of-birth" class="control-label">
                                    Date of Birth
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="date-of-birth" class="required form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="mother-maiden-name" class="control-label">
                                    Mother's Maiden Name
                                </label>
                                <input type="text" id="mother-maiden-name" class="form-control" maxlength="120"/>
                            </div>
                            <div class="form-group" style="margin-top: 39px;">
                                <label for="program-graduated-enrolled" class="control-label">
                                    Program Graduated/Enrolled
                                </label>
                                <input type="text" id="program-graduated-enrolled" class="form-control" maxlength="120"/>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="year-graduate" class="control-label">
                                    Year Graduated
                                </label>
                                <input type="text" id="year-graduate" class="form-control" minlength="4" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>

                            <div class="form-group">
                                <label for="name-of-school-honorable-dismissal-only" class="control-label">
                                    Name of school
                                </label>
                                <input type="text" id="name-of-school-honorable-dismissal-only" class="form-control" maxlength="120"/>
                            </div>
                            <div class="form-group">
                                <label for="valid-id" class="control-label">
                                    Picture copy of your student ID or any valid ID (Back to back) and 2x2 picture
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" id="valid-id fileInput" name="fileInput[]" class="required form-control valid-id-fileInput" accept=".png, .jpg, .jpeg" multiple/>
                                <input type="hidden" id="fileInputHere">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="command-buttons">
                    <button type="button" id="button-back-5" class="btn button-back btn-outline-secondary"
                            data-step_index="5">
                        <i class="fas fa-chevron-left mr-2"></i>
                        <?= lang('back') ?>
                    </button>
                    <button type="button" id="button-next-5" class="btn button-next btn-dark"
                            data-step_index="5">
                        <i class="fas fa-chevron-right mr-2"></i>
                        <?= lang('next') ?>
                    </button>
                </div>
            </div>

            <!-- APPOINTMENT DATA CONFIRMATION -->

            <div id="wizard-frame-6" class="wizard-frame" style="display:none;">
                <div class="frame-container">
                    <h2 class="frame-title"><?= lang('appointment_confirmation') ?></h2>
                    <div class="row frame-content">
                        <div id="appointment-details" class="col-12 col-md-6"></div>
                        <div id="customer-details" class="col-12 col-md-6"></div>
                        <div id="identity-verification-details" class="col-12 col-md-6"></div>
                        <div id="selected-document-details" class="col-12 col-md-6"></div>
                        <div id="imagePreview" class="col-12 col-md-6">

                        </div>
                    </div>
                    <?php if ($this->settings_model->get_setting('require_captcha') === '1'): ?>
                        <div class="row frame-content">
                            <div class="col-12 col-md-6">
                                <h4 class="captcha-title">
                                    CAPTCHA
                                    <button class="btn btn-link text-dark text-decoration-none py-0">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </h4>
                                <img class="captcha-image" src="<?= site_url('captcha') ?>">
                                <input class="captcha-text form-control" type="text" value=""/>
                                <span id="captcha-hint" class="help-block" style="opacity:0">&nbsp;</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="command-buttons">
                    <button type="button" id="button-back-6" class="btn button-back btn-outline-secondary"
                            data-step_index="6">
                        <i class="fas fa-chevron-left mr-2"></i>
                        <?= lang('back') ?>
                    </button>
                    <form id="book-appointment-form" style="display:inline-block" method="post">
                        <button id="book-appointment-submit" type="button" class="btn btn-success">
                            <i class="fas fa-check-square mr-2"></i>
                            <?= ! $manage_mode ? lang('confirm') : lang('update') ?>
                        </button>
                        <input type="hidden" name="csrfToken"/>
                        <input type="hidden" name="post_data"/>
                    </form>
                </div>
            </div>

            <!-- FRAME FOOTER -->

            <div id="frame-footer">
                <small>
                    <span class="footer-powered-by">
                      
                    </span>

                    <span class="footer-options">
                        <span id="select-language" class="badge badge-secondary">
                            <i class="fas fa-language mr-2"></i>
                            <?= ucfirst(config('language')) ?>
                        </span>

                        <a class="backend-link badge badge-primary" href="<?= site_url('backend'); ?>">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <?= $this->session->user_id ? lang('backend_section') : lang('login') ?>
                        </a>
                    </span>
                </small>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to launch the modal when the page loads
    window.onload = function() {
        $('#exampleModalCenter').modal('show');
    };

    // Function to disable the "Submit" button when the checkbox is checked
    // Function to disable the "Submit" button when the checkbox is checked
    document.addEventListener('DOMContentLoaded', function() {
        var checkbox = document.getElementById('checkbox');
        var submitButton = document.getElementById('is_checked_btn');

        checkbox.addEventListener('change', function() {
            submitButton.disabled = !checkbox.checked;
        });
    });
</script>
<?php if ($display_cookie_notice === '1'): ?>
    <?php require 'cookie_notice_modal.php' ?>
<?php endif ?>

<?php if ($display_terms_and_conditions === '1'): ?>
    <?php require 'terms_and_conditions_modal.php' ?>
<?php endif ?>

<?php if ($display_privacy_policy === '1'): ?>
    <?php require 'privacy_policy_modal.php' ?>
<?php endif ?>
<?php ?>
<?php
$baseDirectory = __DIR__;

?>
<script>
    var GlobalVariables = {
        availableServices: <?= json_encode($available_services) ?>,
        availableProviders: <?= json_encode($available_providers) ?>,
        baseUrl: <?= json_encode(config('base_url')) ?>,
        manageMode: <?= $manage_mode ? 'true' : 'false' ?>,
        customerToken: <?= json_encode($customer_token) ?>,
        dateFormat: <?= json_encode($date_format) ?>,
        timeFormat: <?= json_encode($time_format) ?>,
        firstWeekday: <?= json_encode($first_weekday) ?>,
        displayCookieNotice: <?= json_encode($display_cookie_notice === '1') ?>,
        appointmentData: <?= json_encode($appointment_data) ?>,
        providerData: <?= json_encode($provider_data) ?>,
        customerData: <?= json_encode($customer_data) ?>,
        displayAnyProvider: <?= json_encode($display_any_provider) ?>,
        csrfToken: <?= json_encode($this->security->get_csrf_hash()) ?>
    };

    var EALang = <?= json_encode($this->lang->language) ?>;
    var availableLanguages = <?= json_encode(config('available_languages')) ?>;
</script>

<script src="<?= asset_url('assets/js/general_functions.js') ?>"></script>
<script src="<?= asset_url('assets/ext/jquery/jquery.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/jquery-ui/jquery-ui.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/cookieconsent/cookieconsent.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/popper/popper.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/tippy/tippy-bundle.umd.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/datejs/date.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/moment/moment.min.js') ?>"></script>
<script src="<?= asset_url('assets/ext/moment/moment-timezone-with-data.min.js') ?>"></script>
<script src="<?= asset_url('assets/js/frontend_book_api.js') ?>"></script>
<script src="<?= asset_url('assets/js/frontend_book.js') ?>"></script>

<script>

    $(function () {
        FrontendBook.initialize(true, GlobalVariables.manageMode);
        GeneralFunctions.enableLanguageSelection($('#select-language'));
    });


    //uploadFileInput.addEventListener('change', getFileInputImagePreview);
    /*function logFormData(formData) {
        var formDataObject = {};
        formData.forEach((value, key) => {
            formDataObject[key] = value;
        });
        console.log(formDataObject);
    }*/


</script>


<?php google_analytics_script(); ?>
</body>
</html>
