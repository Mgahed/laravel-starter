<script>
    "use strict";

    // Class definition
    var KTSigninGeneral = function () {
        // Elements
        var form;
        var submitButton;
        var validator;

        // Handle form
        var handleValidation = function (e) {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'email': {
                            validators: {
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: 'The value is not a valid email address',
                                },
                                notEmpty: {
                                    message: 'Email address is required'
                                }
                            }
                        },
                        'password': {
                            validators: {
                                notEmpty: {
                                    message: 'The password is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',  // comment to enable invalid state icons
                            eleValidClass: '' // comment to enable valid state icons
                        })
                    }
                }
            );
        }

        var handleSubmitDemo = function (e) {
            // Handle form submit
            submitButton.addEventListener('click', function (e) {
                // Prevent button default action
                e.preventDefault();

                // Validate form
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;


                        // Simulate ajax request
                        setTimeout(function () {
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "You have successfully logged in!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    form.querySelector('[name="email"]').value = "";
                                    form.querySelector('[name="password"]').value = "";

                                    //form.submit(); // submit form
                                    var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                    if (redirectUrl) {
                                        location.href = redirectUrl;
                                    }
                                }
                            });
                        }, 2000);
                    } else {
                        // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });
        }

        var handleSubmitAjax = function (e) {
            // Handle form submit
            submitButton.addEventListener('click', function (e) {
                // Prevent button default action
                e.preventDefault();

                // Validate form
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Check axios library docs: https://axios-http.com/docs/intro
                        axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
                            if (response) {
                                form.reset();

                                // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: {{__('auth.You have successfully logged in')}},
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: {{__('Ok, got it')}},
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });

                                const redirectUrl = form.getAttribute('data-kt-redirect-url');

                                if (redirectUrl) {
                                    location.href = redirectUrl;
                                }
                            } else {
                                // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "Sorry, the email or password is incorrect, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        }).catch(function (error) {
                            Swal.fire({
                                text: error.response.data.message || '__("auth.Sorry looks like there are some errors detected, please try again.")}}',
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: '{{__("auth.Ok!")}}',
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }).then(() => {
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                        });
                    } else {
                        // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: '{{@$message ?? __("auth.Sorry looks like there are some errors detected, please try again.")}}',
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: '{{__("auth.Ok!")}}',
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });
        }

        var isValidUrl = function(url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        }

        // Public functions
        return {
            // Initialization
            init: function () {
                form = document.querySelector('#kt_sign_in_form');
                submitButton = document.querySelector('#kt_sign_in_submit');

                handleValidation();

                if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                    handleSubmitAjax(); // use for ajax submit
                } else {
                    handleSubmitDemo(); // used for demo purposes only
                }
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTSigninGeneral.init();
    });

</script>

<script>
    "use strict";

    // Class definition
    var KTSignupGeneral = function () {
        // Elements
        var form;
        var submitButton;
        var validator;
        var passwordMeter;

        // Handle form
        var handleForm = function (e) {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'First Name is required'
                                }
                            }
                        },
                        'email': {
                            validators: {
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: 'The value is not a valid email address',
                                },
                                notEmpty: {
                                    message: 'Email address is required'
                                }
                            }
                        },
                        'password': {
                            validators: {
                                notEmpty: {
                                    message: 'The password is required'
                                },
                                callback: {
                                    message: 'Please enter valid password',
                                    callback: function (input) {
                                        if (input.value.length > 0) {
                                            return validatePassword();
                                        }
                                    }
                                }
                            }
                        },
                        'password_confirmation': {
                            validators: {
                                notEmpty: {
                                    message: 'The password confirmation is required'
                                },
                                identical: {
                                    compare: function () {
                                        return form.querySelector('[name="password"]').value;
                                    },
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        },
                        'toc': {
                            validators: {
                                notEmpty: {
                                    message: 'You must accept the terms and conditions'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger({
                            event: {
                                password: false
                            }
                        }),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',  // comment to enable invalid state icons
                            eleValidClass: '' // comment to enable valid state icons
                        })
                    }
                }
            );

            // Handle form submit
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validator.revalidateField('password');

                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Simulate ajax request
                        setTimeout(function () {
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "You have successfully reset your password!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    form.reset();  // reset form
                                    passwordMeter.reset();  // reset password meter
                                    //form.submit();

                                    //form.submit(); // submit form
                                    var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                    if (redirectUrl) {
                                        location.href = redirectUrl;
                                    }
                                }
                            });
                        }, 1500);
                    } else {
                        // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: '__("auth.Sorry looks like there are some errors detected, please try again.")}}',
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });

            // Handle password input
            form.querySelector('input[name="password"]').addEventListener('input', function () {
                if (this.value.length > 0) {
                    validator.updateFieldStatus('password', 'NotValidated');
                }
            });
        }


        // Handle form ajax
        var handleFormAjax = function (e) {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'Name is required'
                                }
                            }
                        },
                        'email': {
                            validators: {
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: 'The value is not a valid email address',
                                },
                                notEmpty: {
                                    message: 'Email address is required'
                                }
                            }
                        },
                        'password': {
                            validators: {
                                notEmpty: {
                                    message: 'The password is required'
                                },
                                callback: {
                                    message: 'Please enter valid password',
                                    callback: function (input) {
                                        if (input.value.length > 0) {
                                            return validatePassword();
                                        }
                                    }
                                }
                            }
                        },
                        'password_confirmation': {
                            validators: {
                                notEmpty: {
                                    message: 'The password confirmation is required'
                                },
                                identical: {
                                    compare: function () {
                                        return form.querySelector('[name="password"]').value;
                                    },
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        },
                        'toc': {
                            validators: {
                                notEmpty: {
                                    message: 'You must accept the terms and conditions'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger({
                            event: {
                                password: false
                            }
                        }),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',  // comment to enable invalid state icons
                            eleValidClass: '' // comment to enable valid state icons
                        })
                    }
                }
            );

            // Handle form submit
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validator.revalidateField('password');

                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;


                        // Check axios library docs: https://axios-http.com/docs/intro
                        axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
                            if (response) {
                                form.reset();

                                const redirectUrl = form.getAttribute('data-kt-redirect-url');

                                if (redirectUrl) {
                                    location.href = redirectUrl;
                                }
                            } else {
                                // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: '__("auth.Sorry looks like there are some errors detected, please try again.")}}',
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: '{{__("auth.Ok!")}}',
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        }).catch(function (error) {
                            Swal.fire({
                                text: error.response.data.message || '__("auth.Sorry looks like there are some errors detected, please try again.")}}',
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: '{{__("auth.Ok!")}}',
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }).then(() => {
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                        });

                    } else {
                        // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: error.response.data.message || '__("auth.Sorry looks like there are some errors detected, please try again.")}}',
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });

            // Handle password input
            form.querySelector('input[name="password"]').addEventListener('input', function () {
                if (this.value.length > 0) {
                    validator.updateFieldStatus('password', 'NotValidated');
                }
            });
        }


        // Password input validation
        var validatePassword = function () {
            return (passwordMeter.getScore() > 50);
        }

        var isValidUrl = function(url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        }

        // Public functions
        return {
            // Initialization
            init: function () {
                // Elements
                form = document.querySelector('#kt_sign_up_form');
                submitButton = document.querySelector('#kt_sign_up_submit');
                passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

                if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                    handleFormAjax();
                } else {
                    handleForm();
                }
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTSignupGeneral.init();
    });
</script>
