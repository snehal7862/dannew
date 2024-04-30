$('.show_card').on('click', function () {
    $('.dermatology_card').addClass('d-block');
    $.ajax({
        url: '../../forms/woundcare/src/Lists.php?treatment=1',
        type: 'POST',
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            var data = JSON.parse(response);
            let reversedNotes = data.procedureNotes.reverse();

            let assessments = data.assessments.reverse();

            let dermatology = data.dermatology.reverse();

            $.each(reversedNotes, function (index, p) {
                $('#procedurenote_show').after(`<option value="${p.id}">${p.template}</option>`);
            });

            $.each(assessments, function (index, p) {
                $('#demitology_assesment').after(`<option value="${p.id}">${p.assessment_name}</option>`);
            });

            $.each(dermatology, function (index, p) {
                $('#dermitology_show').after(`<option value="${p.id}">${p.template_name}</option>`);
            });

        },
    });
});

$('.addCptCode').on('click', function () {
    let data = new FormData();
    data.append('cpt_code', document.getElementById('cpt_code').value);
    data.append('template_type', 'Add CPT code');

    $.ajax({
        url: '../../forms/woundcare/resources/saveTemplateData.php',
        type: 'POST',
        data: data,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {

            if (response === 'Cpt code saved') {
                let data = new FormData();
                data.append('template_type', 'Cpt code data');
                $.ajax({
                    url: '../../forms/woundcare/resources/getTemplateData.php',
                    type: 'POST',
                    data: data,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var data = JSON.parse(response);

                        $('.cpt_codes_all').
                            append(`<option value="${data.fields.cpt_code}">${data.fields.cpt_code}</option>`);
                    },
                });
                $('.modal').modal('hide');

                alert('Data Save Successfully...');
            }

            $('.modal').modal('hide');
            $('#cpt_code').val('');
            alert(response);
        },
    });
});

$('.procedureNote').on('click', function (Event) {

    if (checkNote()) {
        Event.preventDefault();
    } else {

        let data = new FormData();
        data.append('template_type', 'Procure Note');
        data.append('treatment_procedure_note', document.getElementById('treatment_procedure_note').value);
        data.append('treatment_additional_note', document.getElementById('treatment_additional_note').value);
        data.append('template', document.getElementById('note').value);
        let cpt10 = $('#treatment_cpt_code').val();
        data.append('treatment_cpt_code', cpt10);

        $.ajax({
            url: '../../forms/woundcare/resources/saveTemplateData.php',
            type: 'POST',
            data: data,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response === 'success first save') {
                    let data = new FormData();
                    data.append('template_type', 'Procure Note');
                    $.ajax({
                        url: '../../forms/woundcare/resources/getTemplateData.php',
                        type: 'POST',
                        data: data,
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            var data = JSON.parse(response);

                            $('.procedure_notes').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['template'] + '</option>');
                            $('#procedure_name').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['template'] + '</option>');
                        },
                    });
                    $('.modal').modal('hide');

                    alert('Data Save Successfully...');
                }
                if (response === 'update success') {
                    $('.modal').modal('hide');
                    alert('Data Update Successfully...');
                }
            },
        });

    }

});


function checkNote () {
    var note = $('#note').val();

    if (note.length <= 0) {
        $('#note_err').html('Note Name is required.').css('color', 'red');
        return true;
    } else {
        $('#note_err').html('');
    }
}

$('#DermatologyAssessmentModalCenter').on('hidden.bs.modal', function (e) {
    $('#assessment-plan').val('');
    $('#assessment-medication').val('');
    $('#assessment_new_name').val('');
    $('#template_name_new_data').val($('#template_name_new_data option:first').val()).trigger('change');
    $('#assessment_icd10').val(null).trigger('change');
});

$('#procedureNotesModel').on('hidden.bs.modal', function (e) {
    $('#treatment_procedure_note').val('');
    $('#note').val('');
    $('#treatment_additional_note').val('');
    $('#treatment_cpt_code').val(null).trigger('change');
    $('#procedure_name').val($('#procedure_name option:first').val()).trigger('change');
    
});

$('#DermatologyModalCenter').on('hidden.bs.modal', function (e) {
    $('#dermatology-template').val();
    $('#dermatology-template_name').val($('#dermatology-template_name option:first').val()).trigger('change');
    $('#dermatology-description').val('');
    $('#dermatology-location').val('');
    $('#dermatology-template').css('display', 'none');
});


$('#exampleModalCenter').on('hidden.bs.modal', function (e) {
        $('#template_name').val($('#template_name option:first').val()).trigger('change');
        $('#template').val('');
        $('#template_hip').val('');
        $('#template_chief_complaint').val('');
        $('#template_current_medication').val('');
        $('#template_medical_history').val('');
        $('#template_allergies').val('');
        $('#template_surgical_history').val('');
        $('#template_social_history').val('');
        $('#template_family_history').val('');
        $('#template_ros').val('');
        $('#template').css('display', 'block');
});

$('#physicalExamModalCenter').on('hidden.bs.modal', function (e) {
        $('#exam_name').val($('#exam_name option:first').val()).trigger('change');
        $('#template_exam_name').val('');
        $('#template_general').val('');
        $('#template_head').val('');
        $('#template_eyes').val('');
        $('#template_nose').val('');
        // $('#template_throat').val('');
        $('#template_ears').val('');
        $('#template_oral_cavity').val('');
        $('#template_neck').val('');
        $('#template_skin_history').val('');
        $('#template_lungs').val('');
        $('#template_abdomen').val('');
        $('#template_extemities').val('');
        $('#template_heart').val('');
        $('#template_back').val('');
        $('#template_pelvic').val('');
        $('#template_breast').val('');
        $('#template_genitourinary').val('');
        $('#template_neurologic').val('');
        $('#template_musculoskeletal').val('');
        $('#template_exam_name').css('display', 'block');
});





$('#addCptCodeModel').on('hidden.bs.modal', function (e) {
    $('#cpt_code').val('');
});

$('#addIcdCodeModel').on('hidden.bs.modal', function (e) {
    $('#icd_code').val('');
    $('#icd_name').val('');
    $('#icd_name_new_data').val($('#icd_name_new_data option:first').val()).trigger('change');
    $('#icd-delete').css({
        color: 'darkgray',
        cursor: 'auto',
        pointerEvents: 'none',
        cursor: 'not-allowed'
    });  
});

$(document).on('keyup', '#cpt_code', function () {
    var input = $(this).val();

    if (input !== '') {
        // Send an AJAX request to a PHP script
        $.ajax({
            url: '../../forms/woundcare/resources/getTemplateData.php',
            method: 'POST',
            data: { input: input, template_type: 'Cpt codes data' },
            success: function (response) {
                $('#suggestion').fadeIn();
                $('#suggestion').html(response);
            },
        });

    } else {
        $('#suggestion').html('');
    }
});

$(document).on('click', 'li', function () {
    $('#cpt_code').val($(this).text());
    $('#suggestion').fadeOut();
});


$('.addIcdCode').on('click', function () {

    let data = new FormData();
    data.append('icd_code', document.getElementById('icd_code').value);
    data.append('icd_name', document.getElementById('icd_new_name').value);
    data.append('template_type', 'Add ICD code');

    $.ajax({
        url: '../../forms/woundcare/resources/saveTemplateData.php',
        type: 'POST',
        data: data,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {

            if (response === 'success first save') {
                let data = new FormData();
                data.append('template_type', 'Icd code Get data');
                $.ajax({
                    url: '../../forms/woundcare/resources/getTemplateData.php',
                    type: 'POST',
                    data: data,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var data = JSON.parse(response);

                        $('#icd_name_new_data').
                            append(`<option value="${data.fields.id}">${data.fields.icd_name}</option>`);
                        
                        $('.icd_codes_all').
                            append(`<option value="${data.fields.icd_name}">${data.fields.icd_code}</option>`);
                    },
                });
                $('#addIcdCodeModel').modal('hide');

                alert('Data Save Successfully...');
            }

            if (response === 'update success') {
                $('#addIcdCodeModel').modal('hide');
                alert('Data updated Successfully...');

            }

            $('#cpt_code').val('');

        },
    });
});