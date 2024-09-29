let carChecked = false
var KTWizard6 = function () {
    // Base elements
    var _wizardEl;
    var _formEl;
    var _wizardObj;
    var _validations = [];

    // Private functions
    var _initWizard = function () {
        // Initialize form wizard
        _wizardObj = new KTWizard(_wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: false  // allow step clicking
        });

        // Validation before going to next page
        _wizardObj.on('change', function (wizard) {
            if (wizard.getStep() > wizard.getNewStep()) {
                return; // Skip if stepped back
            }

            // Validate form before change wizard step
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        wizard.goTo(wizard.getNewStep());

                        KTUtil.scrollTop();
                    } else {
                        Swal.fire({
                            text: langs[LANG].sorry_you_cant_leave_required_input,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: langs[LANG].ok_got_it,
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        })
                    }
                });
            }

            return false;  // Do not change wizard step, further action will be handled by he validator
        });

        // Change event
        _wizardObj.on('changed', function (wizard) {
            KTUtil.scrollTop();
        });

        // Submit event
        _wizardObj.on('submit', function (wizard) {
            Swal.fire({
                text: langs[LANG].all_good_please_confirm_form,
                icon: "success",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: langs[LANG].yes_submit,
                cancelButtonText: langs[LANG].no_cancel,
                customClass: {
                    confirmButton: "btn font-weight-bold btn-primary",
                    cancelButton: "btn font-weight-bold btn-default"
                }
            }).then(function (result) {
                if (result.value) {
                    let bodyFormData = $("#visitor_form")[0]
                    let formData = new FormData(bodyFormData);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: `${HOST_URL}/${LANG}/dashboard/visitor-confirmation`,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        beforeSend: function () {
                            $('body').append(`<div class="" id="loadingDiv"><div></div><div></div><div></div><div></div></div>`);
                            $('body').off('click');
                            $('#loadingDiv').addClass('lds-ring');
                            $("#VisitInfo").fadeOut()
                        },
                        success: function (data) {
                            toastr.success(data.message);
                            $("#VisitConfirm").show();
                        },
                        complete: function () {
                            $('#loadingDiv').removeClass('lds-ring');
                        },
                        error: function (jqXhr, textStatus, errorMessage) {

                            console.log(jqXhr);

                            $('#loadingDiv').removeClass('lds-ring');
                            $("#VisitInfo").fadeIn();

                            let errors = jqXhr.responseJSON.errors;
                            let message;

                            if (errors) {
                                message = errors[Object.keys(errors)[0]][0]
                            } else {
                                message = jqXhr.responseJSON.message ?? langs[LANG].sorry_looks_like_some_errors_detected_try_again;
                            }

                            Swal.fire({
                                text: message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: langs[LANG].ok_got_it,
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light"
                                }
                            });
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: langs[LANG].your_form_has_been_submitted,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: langs[LANG].ok_got_it,
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-primary",
                        }
                    });
                }
            });
        });
    }


    var _initValidation = function (car_checked) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    visitor_type: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].id_type_required,
                            }
                        }
                    },
                    visit_reason: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].visit_reason_req
                            }
                        }
                    },
                    site_id: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].site_required
                            }
                        }
                    },
                    department_id: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].department_required
                            }
                        }
                    },
                    host_id: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].host_required
                            }
                        }
                    },
                    from_date: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].from_date_required
                            },
                        }
                    },
                    to_date: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].to_date_required,
                            },
                        }
                    },
                    from_fromtime: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].from_time_required
                            },
                        }
                    },
                    from_totime: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].to_time_required,
                            },
                        }
                    },
                    select_transport: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].transport_way_required,
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));

        //step 2
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].first_name_required,
                            }
                        }
                    },
                    last_name: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].last_name_required,
                            }
                        }
                    },
                    id_type: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].id_type_required,
                            }
                        }
                    },
                    id_number: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].id_number_required,
                            },
                            regexp: {
                                regexp: /^[0-9]+|not_in:0/,
                                message: langs[LANG].id_number_must_be_positive,
                            }
                        }
                    },
                    mobile: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].mobile_required,
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].email_is_required,
                            }
                        }
                    },
                    gender: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].gender_req,
                            }
                        }
                    },
                    company: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].company_required,
                            }
                        }
                    },
                    position: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].position_required,
                            }
                        }
                    },
                    personal_photo2: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].personal_photo_required,
                            }
                        }
                    },
                    id_copy2: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].id_copy_required,
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));
    }

    return {
        // public functions
        init: function (car_checked) {
            _wizardEl = KTUtil.getById('kt_wizard');
            _formEl = KTUtil.getById('visitor_form');

            _initWizard();
            _initValidation(car_checked);
        }
    };
}();

jQuery(document).ready(function () {
    KTWizard6.init(carChecked);
});

$("#show_car_details").on('change', function (e) {
    $("#action-next").prop('disabled', false).attr('data-wizard-type', 'action-next');
    if ($(this).val() == 'car') {
        $("#transport_details_section").css('display', 'none');
        $("#car_details_section").css('display', 'block');

        // $('#invalid-platEn').css('display', 'block');
        // $('#invalid-platAr').css('display', 'block');
        // if (($("#number_en").val().split('').length > 0 || $("#number_ar").val().split('').length > 0) && ($("#plate_ar").val().split('').length == 3 || $("#plate_en").val().split('').length == 3)) {
        //     $("#action-next").prop('disabled', false).attr('data-wizard-type', 'action-next');
        //     $('#invalid-platEn').css('display', 'none');
        //     $('#invalid-platAr').css('display', 'none');
        // }
    } else if ($(this).val() == 'transport') {
        $("#action-next").prop('disabled', true).attr('data-wizard-type', 'no')

        $("#car_details_section").css('display', 'none');
        $("#transport_details_section").css('display', 'block');
        $('#invalid-feedback').css('display', 'block');
        if ($("#transport_way").val() != '') {
            $("#action-next").prop('disabled', false).attr('data-wizard-type', 'action-next')
            $('#invalid-feedback').css('display', 'none');
        }
    } else {
        $("#car_details_section").css('display', 'none');
        $("#transport_details_section").css('display', 'none');
    }
});

$("#transport_way").on('keyup', function (e) {
    if ($("#transport_way").val() == '') {
        $("#action-next").prop('disabled', true).attr('data-wizard-type', 'no')
        $('#invalid-feedback').css('display', 'block')
    } else {
        $("#action-next").prop('disabled', false).attr('data-wizard-type', 'action-next')
        $('#invalid-feedback').css('display', 'none')
    }
});

$("#id_type").on('change', function () {
    let idName = $("#id_type").val();
    $("#myId").val('');

    if (!idName) {
        $("#idName").html('ID Number')
    } else {
        $("#idName").html(idName).attr(idName);
        $("#myId").attr("placeholder", idName);

    }
    let length = $(this).find(':selected').attr('data-length');
    if (length > 0) {
        $("#myId").attr('oninput',
            `javascript:if (this.value.length > ${length}) this.value = this.value.slice(0, ${length});`
        );
    }
});


// $('.digit').on('keyup', function (e) {
//     setTimeout(() => {
//         let number = false;
//         let plate = false;
//         if ($("#plate_en").val().split('').length == 3 || $("#plate_ar").val().split('').length == 3) {
//             plate = true;
//             $('#invalid-platEn').css('display', 'none');
//         } else {
//             $("#action-next").prop('disabled', true).attr('data-wizard-type', 'no')
//             $('#invalid-platEn').css('display', 'block');
//         }
//         if ($("#number_en").val().split('').length > 0 || $("#number_ar").val().split('').length > 0) {
//             number = true;
//             $('#invalid-platAr').css('display', 'none');
//         } else {
//             $('#invalid-platAr').css('display', 'block');
//             $("#action-next").prop('disabled', true).attr('data-wizard-type', 'no')
//         }
//         if (plate && number) {
//             $("#action-next").prop('disabled', false).attr('data-wizard-type', 'action-next')
//         }
//     });
// });


