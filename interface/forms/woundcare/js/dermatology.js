
$('.dermatology-key').on('change', function () {

    if (this.value == '0' || this.value == 'Select Template') {
        $('#dermatology-template').val('');
        $('#dermatology-description').val('');
        $('#dermatology-location').val('');

        if (this.value == '0') {
            $('#dermatology-template').css('display', 'block');
        } 
        
        if (this.value == 'Select Template'){
            $('#dermatology-template').css('display', 'none');
        }
        
        $('#dermitology-delete').css({
            color: 'darkgray',
            cursor: 'auto',
            pointerEvents: 'none',
            cursor: 'not-allowed'
        });
    } else {
        $('#dermatology-template').css('display', 'none');
        $('#dermitology-delete').css({
            color: '#5DBDCE',
            cursor: 'pointer',
            pointerEvents:'auto'
        });
        let data = new FormData();
        data.append('template_type', 'Dermatology');
        data.append('template_id', jQuery('#dermatology-template_name option:selected').val());
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

                $('#dermatology-template').val(data['fields']['template_name']);
                $('#dermatology-description').val(data['fields']['description']);
                $('#dermatology-location').val(data['fields']['location']);
                $('#dermitology-delete').attr('data-id',data['fields']['id']);
            },
        });
    }
});

/**
 * Fill the dermatology details into the template form when user will select from dropdown
 */
// $('.dermatology').on('change', function () {
//     let data = new FormData();
//     data.append('template_type', 'Dermatology');
//     data.append('template_id', $(this).val());
//     $.ajax({
//         url: '../../forms/woundcare/resources/getTemplateData.php',
//         type: 'POST',
//         data: data,
//         async: true,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (response) {
//             var data = JSON.parse(response);
//             if(data['fields'] !== false){
//                 $('#dermatology-template').val(data['fields']['template_name']);
//                 $('#description').val(data['fields']['description']);
//                 $('#location').val(data['fields']['location']);
    
//                 $("#dermitologyDelete").removeClass('d-none');
                    
//                 $('#dermitologyDeleteBtn').attr('data-id',data['fields']['id']);
//             }else{
//                 $('#dermatology-template').val('');
//                 $('#description').val('');
//                 $('#location').val('');
//                 $("#dermitologyDelete").addClass('d-none');
//             }
           
//         },
//     });
// });

// delete template function 

// $(document).on('click',"#dermitologyDeleteBtn", function(e){
    $(document).on('click', '[id^="dermitologyDeleteBtn-"]', function() {

    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {

    let woundId = $(this).attr('dermo-card');
    
                $('#dermatology-template').val('');
                $('#description-'+woundId).val('');
                $('#location-'+woundId).val('');
                $(`#dermitologyDelete-${woundId}`).addClass('d-none');

                $(`#woundCareDelete-${woundId}`).addClass('d-none');

                $(`#dermatology-templates_${woundId} option:first`).prop('selected', true);
                $(`#dermatology-templates_${woundId}`).select2();
        
                function reloadSelect2() {
                    $(`#dermatology-templates_${woundId}`).select2('destroy');
                    $(`#dermatology-templates_${woundId}`).select2();
                }
        
                reloadSelect2();
    }

    
})

$(document).on('click',"#dermitology-delete", function(e){
    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {
    let id = $(this).attr('data-id');
    let data = new FormData();
    data.append('template_type', 'Dermitology Delete');
    data.append('template_id', id);
    $.ajax({
        url: '../../forms/woundcare/resources/templateDelete.php',
        type: 'POST',
        data: data,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#dermatology-template').val('');
            $('#description-1').val('');
            $('#location-1').val('');
            $("#dermitologyDelete").addClass('d-none');
            $('#dermatology-template').val('');
            $('#dermatology-description').val('');
            $('#dermatology-location').val('');
            $('.dermatology option[value="' + id + '"]').remove();
            $('select[id^="dermatology-templates_"] option[value="' + id + '"]').remove();
            $('#dermatology-templates_1 option[value="' + id + '"]').remove();
            $('#dermatology-template_name option[value="' + id + '"]').remove();

            $('#dermitology-delete').css({
                color: 'darkgray',
                cursor: 'auto',
                pointerEvents: 'none',
                cursor: 'not-allowed'
            });
        },
    });
    
    } 

});

$(document).on('change', 'select[id^="dermatology-templates_"]', function () {

    let count = $(this).data('count');

    let data = new FormData();
    data.append('template_type', 'Dermatology');
    data.append('template_id', $(this).val());
    // alert('fdfd')
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
           
            // $('.dermatology-template').val(data['fields']['template_name']);
            $('#description-'+ count).val(data['fields']['description']);
            $('#location-' + count).val(data['fields']['location']);

            if(data['fields'] !== false){
                $('#dermatology-template').val(data['fields']['template_name']);
                $('#description').val(data['fields']['description']);
                $('#location').val(data['fields']['location']);
                $(`#dermitologyDelete-${count}`).removeClass('d-none');
                $(`#dermitologyDeleteBtn-${count}`).attr('data-id',data['fields']['id']);
                triggerInputForTextAreas();
            }else{
                $('#dermatology-template').val('');
                $('#description').val('');
                $('#location').val('');
                $(`#dermitologyDelete-${count}`).addClass('d-none');
                triggerInputForTextAreas();
           }
        },
    });
});

/**
 * This is the click event to call API to insert dermitology data
 */
$('.dermatology-Information').on('click', function () {
    if (checkdermatologydata()) {

        Event.preventDefault();
    } else {
        let data = new FormData();
        data.append('template_type', 'Dermatology');
        data.append('template_name', document.getElementById('dermatology-template').value);
        data.append('description', $('#dermatology-description').val());
        data.append('location', $('#dermatology-location').val());

        $.ajax({
            url: '../../forms/woundcare/resources/saveTemplateData.php',
            type: 'POST',
            data: data,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {

                if (response == 'success first save') {
                    let data = new FormData();
                    data.append('template_type', 'Dermatology Update');
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

                            $('.dermatology-templates').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['template_name'] + '</option>');
                            $('#dermatology-template_name').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['template_name'] + '</option>');
                        },
                    });
                    $('.modal').modal('hide');

                    alert('Data Save Successfully...');
                }
                if (response == 'update success') {
                    $('.modal').modal('hide');
                    alert('Data Save Successfully...');
                }
            },
        });
    }
});

/**
 * Validations for Dermatology form
 */
function checkdermatologydata () {
    var user = $('#dermatology-template').val();

    if (user.length <= 0) {
        $('#dermatology-template_err').html('Template Name is required.').css('color', 'red');
        return true;
    } else {
        $('#dermatology-template_err').html('');
    }
}

$(document).on('change', '.code-change-dermitology', function () {
    var dermitology_count = $(this).attr('data-dermatologyLocationCountTotal');

    $('#wc_medication_icd-' + dermitology_count).val($(this).val());
});

$(document).on('change', '.procedure_notes_dermitology', function () {
    let number = $(this).data('count');
    let problemNumber = $(this).data('problem');
    if (this.value === '0' || this.value === 'Choose an Option') {
        $('#problem_' + problemNumber + '_procedure_' + number).val('');
        $('#problem_' + problemNumber + '_additional_' + number).val('');
        $('#problem_' + problemNumber + '_cpt_' + number).val('');
        $('#problem_' + problemNumber + '_cpt_' + number).val(null).trigger('change');
        $('#dermo_wc_cpt_' + problemNumber + '_code_' + number).val('');
        triggerInputForTextAreas();
    } else {
        let data = new FormData();
        data.append('template_type', 'Procedure Note');
        data.append('template_id', this.value);
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
                $('#problem_' + problemNumber + '_procedure_' + number).
                    val(data['fields']['treatment_procedure_note']);
                $('#problem_' + problemNumber + '_additional_' + number).
                    val(data['fields']['treatment_additional_note']);
                $('#problem_' + problemNumber + '_cpt_' + number).
                    val(data['fields']['treatment_cpt_code'].split(','));
                $('#problem_' + problemNumber + '_cpt_' + number).
                    val(data['fields']['treatment_cpt_code'].split(',')).
                    trigger('change');
                $('#dermo_wc_cpt_' + problemNumber + '_code_' + number).
                    val(data['fields']['treatment_cpt_code'].split(','));
                triggerInputForTextAreas();    
            },
        });
        
    }
});

$(document).on('change', 'select[id^="dermitology_assessment-"]', function () {
    let dermatologyCount = $(this).attr('data-dermatologyLocationCountTotal');
    
    if (this.value === '0' || this.value === 'Select Template') {
        $('#wc_plan_dermitology-' + dermatologyCount).val('');
        $('#wc_medication_dermitology-' + dermatologyCount).val('');
        $('#wc_wound_medication_icd-' + dermatologyCount).val(null).trigger('change');
        $('#wc_medication_icd-' + dermatologyCount).val('');
    } else {

        let data = new FormData();
        data.append('template_type', 'Assessment');
        data.append('template_id', this.value);
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
                $('#wc_plan_dermitology-' + dermatologyCount).val(data['fields']['plan']);
                $('#wc_medication_dermitology-' + dermatologyCount).val(data['fields']['medication']);
                $('#wc_wound_medication_icd-' + dermatologyCount).
                    val(JSON.parse(data['fields']['ICD_10']).split(',')).
                    trigger('change');
                $('#wc_medication_icd-' + dermatologyCount).val(JSON.parse(data['fields']['ICD_10']).split(','));
            },
        });
    }
});

$('.save-assessment').click(function () {

    let plan = $('#assessment-plan').val();
    let medication = $('#assessment-medication').val();
    let assessment_name = $('#assessment_new_name').val();
    let icd10 = $('#assessment_icd10').val();
    let data = new FormData();
    data.append('template_name', assessment_name);
    data.append('ICD_10', icd10);
    data.append('medication', medication);
    data.append('plan', plan);
    data.append('template_type', 'Assessment');

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
                data.append('template_type', 'Assessment Update');
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
                        $('#template_name_new_data').
                            append('<option value="' + data['fields']['id'] + '">' +
                                data['fields']['assessment_name'] + '</option>');
                        $('.assessment_template_select').
                            append('<option value="' + data['fields']['id'] + '">' +
                                data['fields']['assessment_name'] + '</option>');
                    },
                });
                $('.modal').modal('hide');

                alert('Data Save Successfully...');
            }
            if (response === 'update success') {
                $('.modal').modal('hide');
                alert('Data updated Successfully...');

            }
        },
    });

});


function switchDermoTreatment(id) {
    $(`#firstTreatmentDermo_${id}`).addClass('d-none');
    $(`#secondTreatmentDermo_${id}`).removeClass('d-none');
}

function switchEditDermoTreatment(id) {
    $(`#firstTreatmentEditDermo_${id}`).addClass('d-none');
    $(`#secondTreatmentEditDermo_${id}`).removeClass('d-none');
}



