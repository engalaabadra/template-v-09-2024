"use strict";

$(document).on('click', '#AddVisitor', function (e) {
    e.preventDefault();
    $('#create_visitor_modal').modal();
});

$(document).on('click', '#addNewUser', function (e) {
    $("#userForm").css('display', 'block');
    e.preventDefault();
});

$(document).on('click', '#submitVisitForm', function (e) {
    e.preventDefault();

    var selectVisitors = $('#visitors_id').val();

    if (selectVisitors == null) {
        toastr.error(langs[LANG].you_have_to_choose_least_one_visitor)
    } else if (selectVisitors.length >= 1) {

        $("#visitForm").submit();

        $(this).prop('disabled', true)
            .addClass('spinner spinner-white spinner-right')
            .text(langs[LANG].please_wait);

    } else {
        toastr.error(langs[LANG].you_have_to_choose_least_one_visitor);
    }
});

$(document).on('click', '.delete_visitor', function (e) {
    e.preventDefault();
    var item_id = $(this).data('visitor_id');
    $(`#visitorSelectedTable #row-${item_id}`).remove();
    $(`#visitors_id option[value=${item_id}]`).remove();
});


$(document).on('click', '#saveVisitors', function (e) {
    e.preventDefault();

    var selectUsers = $('#selectUsers').val();

    $.ajax({
        url: `${HOST_URL}/${LANG}/dashboard/visitor/check-request`,
        method: 'GET',
        data: {ids: selectUsers},
        success: function (data) {
            if (data.length != 0) {
                Object.keys(data).forEach(el => {
                    toastr.error(`${data[el]} ${langs[LANG].visitor_have_active_request}`);
                });

                return true;

                // console.log(data);
                // let newVisitors = visitors.filter(v => Object.keys(data).includes(v.id));
                //
                // $("#selectUsers").html('');
                // newVisitors.forEach(visitor => {
                //     $("#selectUsers").append(
                //         `<option value='${visitor.id}' selected>${visitor.name}</option>`
                //     );
                // });
            } else {
                if (selectUsers.length >= 1) {
                    selectUsers.forEach(item => {
                        $("#visitors_id").append(
                            `<option value=${parseInt(item)} selected></option>`
                        );
                    });

                    $.get({
                        url: `${HOST_URL}/${LANG}/dashboard/visitors-by-id`,
                        data: {ids: selectUsers},
                        method: 'GET',
                        success: function (visitors) {
                            if (visitors.length >= 1) {
                                $("#visitors_head").show();
                                $("#visitorSelectedTable").empty();
                                visitors.forEach(visitor => {
                                    $("#visitorSelectedTable").append(
                                        `<tr id="row-${visitor.id}">
                                <td>${visitor.full_name}</td>
                                <td>${visitor.company.name ?? '---'}</td>
                                <td>${visitor.id_number ?? '---'}</td>
                                <td>${visitor.email ?? '---'}</td>
                                <td>${visitor.nationality ?? '---'}</td>
                                <td><b style="color:#FFA800;">${langs[LANG].pending}</b></td>
                                <td style="cursor: pointer;" class="delete_visitor" data-visitor_id="${visitor.id}">
                                    <i class="fas fa-times-circle"></i>
                                </td>
                            </tr>`
                                    );
                                });
                            }
                        }
                    })

                    toastr.success(langs[LANG].visitors_saved_successfully);

                    setTimeout(() => {
                        $('#create_visitor_modal').modal('hide');
                    }, 200);

                } else {
                    toastr.error(langs[LANG].you_have_to_choose_least_one_visitor);
                }
            }
        }
    });
});

function getVisitors(visitor_type) {
    let users;
    $.ajax({
        url: `${HOST_URL}/${LANG}/dashboard/get-visitor?type=${visitor_type}`,
        method: 'GET',
        success: function (data) {
            users = data.data;
            $("#selectUsers").html('');
            for (let i = 0; i < users.length; i++) {
                $("#selectUsers").append(
                    `<option value="${users[i].id}">${users[i].first_name} ${users[i].last_name ?? ''}</option>`
                )
            }
        }
    })
}

if (old_visitors != null) {
    if (old_visitors.length >= 1) {
        old_visitors.forEach(item => {
            $("#visitors_id").append(
                `<option value=${parseInt(item)} selected></option>`
            );
        });

        $.get({
            url: `${HOST_URL}/${LANG}/dashboard/visitors-by-id`,
            data: {ids: old_visitors},
            method: 'GET',
            success: function (visitors) {
                if (visitors.length >= 1) {
                    $("#visitors_head").show();
                    $("#visitorSelectedTable").empty();
                    visitors.forEach(visitor => {
                        $("#visitorSelectedTable").append(
                            `<tr id="row-${visitor.id}">
                                <td>${visitor.full_name}</td>
                                <td>${visitor.company.name ?? '---'}</td>
                                <td>${visitor.id_number ?? '---'}</td>
                                <td>${visitor.email ?? '---'}</td>
                                <td>${visitor.nationality ?? '---'}</td>
                                <td><b style="color: #FFA800;">${langs[LANG].pending}</b></td>
                                <td style="cursor: pointer;" class="delete_visitor" data-visitor_id="${visitor.id}">
                                    <i class="fas fa-times-circle"></i>
                                </td>
                            </tr>`
                        );

                        $("#selectUsers").append(
                            "<option value='" + visitor.id + "' selected>" + visitor.full_name + "</option>"
                        );

                    });
                }
            }
        });
    }
}

// Class definition
var KTWizard8 = function () {
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
                    var bodyFormData = $("#visitor_form")[0]
                    var formData = new FormData(bodyFormData);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: `${HOST_URL}/${LANG}/dashboard/visitors`,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: formData,
                        enctype: 'multipart/form-data',
                        success: function (data) {
                            toastr.success(data.message);
                            $("#selectUsers").append(
                                "<option value='" + data.id + "' selected>" + data.name + "</option>"
                            );

                            setTimeout((result) => {
                                $("#userForm").slideUp();
                                result.goFirst();
                            }, 200);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var errors = xhr.responseJSON.errors;
                            Swal.fire({
                                text: errors[Object.keys(errors)[0]][0] ?? langs[LANG].sorry_looks_like_some_errors_detected_try_again,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: langs[LANG].ok_got_it,
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light"
                                }
                            })
                        }

                    })


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

    var _initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1
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
                    id_type: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].id_type_required
                            }
                        }
                    },
                    id_number: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].id_number_required
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
                                message: langs[LANG].mobile_required
                            },
                            regexp: {
                                regexp: /^[0-9][0-9]/,
                                message: langs[LANG].mobile_number_must_be_valid,
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].email_is_required
                            },
                            emailAddress: {
                                message: langs[LANG].value_is_not_valid_email_address
                            }, regexp: {
                                regexp: /(.*)@(.*)\.(.*)/,
                                message: langs[LANG].email_must_be_valid,
                            }
                        }
                    },
                    company: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].company_required
                            }
                        }
                    }
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

        // Step 2
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    country: {
                        validators: {
                            notEmpty: {
                                message: langs[LANG].country_required,

                            }
                        }
                    }
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

        _validations.push(FormValidation.formValidation(
            _formEl,
            {}
        ));
    }

    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById('kt_wizard');
            _formEl = KTUtil.getById('visitor_form');

            _initWizard();
            _initValidation();
        }
    };
}();

jQuery(document).ready(function () {
    KTWizard8.init();
});


