$(document).ready(function () {
    $('#woundCareModalCenter').on('hidden.bs.modal', function () {
        $('#wound_template').val('');
        $('#wound_template_name option:first').prop('selected', true);
        $('#template_wc_side option:first').prop('selected', true);
        $('#template_wc_anatomical option:first').prop('selected', true);
        $('#template_wc_location option:first').prop('selected', true);
        $('#template_wc_wound_type option:first').prop('selected', true);
        $('#template_wc_thickness option:first').prop('selected', true);
        $('#template_wc_drainage_amount option:first').prop('selected', true);
        $('#template_wc_drainage_description option:first').prop('selected', true);
        $('#template_wc_surgically option:first').prop('selected', true);
        $('input[name=\'template_wc_undermining\']').removeAttr('checked', true);
        $('input[name=\'template_wc_tunneling\']').removeAttr('checked', true);
        $('input[name=\'template_wc_ordo\']').removeAttr('checked', true);
         $('#wound-delete').css({
                color: 'darkgray',
                cursor: 'auto',
                pointerEvents: 'none',
                cursor: 'not-allowed'
            });
        $('#wound_template').css('display', 'none');
    });
});


$(document).on('keyup', '.click-event-class', function (event) {
    calculateSurfaceArea(event);

});

function calculateSurfaceArea (event = null) {

    if (event != null) {
        let selectedElement = $(event.target);
        let unique = selectedElement.data('unique-id');
        let s = $(document).find('#wc_width-' + unique).val() ? $(document).find('#wc_width-' + unique).val() : 1;
        let v = $(document).find('#wc_length-' + unique).val() ? $(document).find('#wc_length-' + unique).val() : 1;
        let num = parseFloat(s) * parseFloat(v);
        $(document).find('#wc_surfacearea-' + unique).val(parseFloat(num).toFixed(2));
    } else {
        let s = document.getElementById('wc_length-1').value ? document.getElementById('wc_length-1').value : 1;
        let v = document.getElementById('wc_width-1').value ? document.getElementById('wc_width-1').value : 1;
        let num = parseFloat(s) * parseFloat(v);
        document.getElementById('wc_surfacearea-1').value = parseFloat(num).toFixed(2);
    }
    calculateVolume(event);
}

function calculateVolume (event = null) {
    if (event != null) {
        let selectedElement = $(event.target);
        let unique = selectedElement.data('unique-id');
        let sd = $(document).find('#wc_width-' + unique).val() ? $(document).find('#wc_width-' + unique).val() : 1;
        let vd = $(document).find('#wc_length-' + unique).val()
            ? $(document).find('#wc_length-' + unique).val()
            : 1;
        let d = $(document).find('#wc_depth-' + unique).val() ? $(document).find('#wc_depth-' + unique).val() : 1;
        let num = parseFloat(sd) * parseFloat(vd) * parseFloat(d);
        $(document).find('#wc_volume-' + unique).val(parseFloat(num).toFixed(2));
    } else {
        let sd = document.getElementById('wc_length-1').value ? document.getElementById('wc_length-1').value : 1;
        let vd = document.getElementById('wc_width-1').value ? document.getElementById('wc_width-1').value : 1;
        let d = document.getElementById('wc_depth-1').value ? document.getElementById('wc_depth-1').value : 1;
        let num = parseFloat(sd) * parseFloat(vd) * parseFloat(d);
        document.getElementById('wc_volume-1').value = parseFloat(num).toFixed(2);
    }
}

$(function () {

    $('#resetForm').click(function () {
        $('#my_form')[0].reset();
    });

    $('.select2').select2();

    $('.save').click(function () {
        top.restoreSession();
        $('#my_form').submit();
    });
    $('.dontsave').click(function () {
        parent.closeTab(window.name, false);
    });
    $('#printform').click(function () {
        PrintForm();
    });
});

$('.wound_key').on('change', function () {
    if (this.value == '0' || this.value == 'Select Template') {
        $('#wound_template').val('');
        $('#template_wc_side option:first').prop('selected', true);
        $('#template_wc_anatomical option:first').prop('selected', true);
        $('#template_wc_location option:first').prop('selected', true);
        $('#template_wc_wound_type option:first').prop('selected', true);
        $('#template_wc_thickness option:first').prop('selected', true);
        $('#template_wc_drainage_amount option:first').prop('selected', true);
        $('#template_wc_drainage_description option:first').prop('selected', true);
        $('#template_wc_surgically option:first').prop('selected', true);
        $('input[name=\'template_wc_undermining\']').attr('checked', false);
        $('input[name=\'template_wc_tunneling\']').attr('checked', false);
        $('input[name=\'template_wc_ordo\']').attr('checked', false);

        $('input[id^="wc_volume-"]').val('');
        if (this.value == '0') {
            $('#wound_template').css('display', 'block');
        } 
        
        if (this.value == 'Select Template'){
            $('#wound_template').css('display', 'none');
        }
        $('#wound-delete').css({
            color: 'darkgray',
            cursor: 'auto',
            pointerEvents: 'none',
            cursor: 'not-allowed'
        });
    } else {
        $('#wound_template').css('display', 'none');
        $('#wound-delete').css({
            color: '#5DBDCE',
            cursor: 'pointer',
            pointerEvents:'auto'
        });
        let data = new FormData();
        $('input[name=\'template_wc_undermining\']').attr('checked', false);
        $('input[name=\'template_wc_tunneling\']').attr('checked', false);
        $('input[name=\'template_wc_ordo\']').attr('checked', false);
        data.append('template_type', 'Wound Template');
        data.append('template_id', jQuery('#wound_template_name option:selected').val());
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
                $('#template_wc_undermining').attr('checked', false);

                $('#wound_template').val(data['fields']['wound_template_name']);
                $('#template_wc_side').val(data['fields']['template_side']);
                $('#template_wc_anatomical').val(data['fields']['template_anatomical_action']);
                $('#template_wc_location').val(data['fields']['template_location']);
                $('#template_wc_wound_type').val(data['fields']['template_wound_type']);
                $('#template_wc_thickness').val(data['fields']['template_wound_thickness']);
                $('#template_wc_drainage_amount').val(data['fields']['template_drainage_amount']);
                $('#template_wc_drainage_description').val(data['fields']['template_drainage_description']);
                $('#template_wc_surgically').val(data['fields']['template_debrided_surgically_created']);
                if (data['fields']['template_undermining'] === 'Yes') {
                    $('.template_wc_undermining-yes').attr('checked', true);
                } else if (data['fields']['template_undermining'] === 'No') {
                    $('.template_wc_undermining-no').attr('checked', true);
                } else {
                    $('input[name=\'template_wc_undermining\']').attr('checked', false);
                }
                if (data['fields']['template_tunneling'] === 'Yes') {
                    $('.template_wc_tunneling-yes').attr('checked', true);
                } else if (data['fields']['template_tunneling'] === 'No') {
                    $('.template_wc_tunneling-no').attr('checked', true);
                } else {
                    $('input[name=\'template_wc_tunneling\']').attr('checked', false);
                }
                if (data['fields']['template_ordo'] === 'Yes') {
                    $('.template_wc_ordo-yes').attr('checked', true);
                } else if (data['fields']['template_ordo'] === 'No') {
                    $('.template_wc_ordo-no').attr('checked', true);
                } else {
                    $('input[name=\'template_wc_ordo\']').attr('checked', false);
                }
                $('#wound-delete').attr('data-id',data['fields']['id']);
            },
        });
    }
});

$(document).on('change', 'select[id^="woundTempalte-"]', function () {
    let count = $(this).data('count');
    
    $('.wc_undermining-no-' + count).attr('checked', false);
    $('.wc_undermining-yes-' + count).attr('checked', false);
    $('.wc_tunneling-yes-' + count).attr('checked', false);
    $('.wc_tunneling-no-' + count).attr('checked', false);
    $('.wc_ordo-yes-' + count).attr('checked', false);
    $('.wc_ordo-no-' + count).attr('checked', false);

    let data = new FormData();
    data.append('template_type', 'Wound Template');
    data.append('template_id', $(this).val());
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
            if(data['fields'] !== false){
                $('#wound_template').val(data['fields']['wound_template_name']);
                $('#wc_side-' + count).val(data['fields']['template_side']);
                $('#wc_anatomical-' + count).val(data['fields']['template_anatomical_action']);
                $('#wc_location-' + count).val(data['fields']['template_location']);
                $('#wc_wound_type-' + count).val(data['fields']['template_wound_type']);
                $('#wc_thickness-' + count).val(data['fields']['template_wound_thickness']);
                $('#wc_drainage_amount-' + count).val(data['fields']['template_drainage_amount']);
                $('#wc_drainage_description-' + count).val(data['fields']['template_drainage_description']);
                $('#wc_surgically-' + count).val(data['fields']['template_debrided_surgically_created']);
                if (data['fields']['template_undermining'] === 'Yes') {
                    $('.wc_undermining-yes-' + count).attr('checked', true);
                } else if (data['fields']['template_undermining'] === 'No') {
                    $('.wc_undermining-no-' + count).attr('checked', true);
                } else {
                    $('.wc_undermining-no-' + count).attr('checked', false);
                    $('.wc_undermining-yes-' + count).attr('checked', false);
                }
                if (data['fields']['template_tunneling'] === 'Yes') {
                    $('.wc_tunneling-yes-' + count).attr('checked', true);
                } else if (data['fields']['template_tunneling'] === 'No') {
                    $('.wc_tunneling-no-' + count).attr('checked', true);
                } else {
                    $('.wc_tunneling-no-' + count).attr('checked', false);
                    $('.wc_tunneling-yes-' + count).attr('checked', false);
                }
                if (data['fields']['template_ordo'] === 'Yes') {
                    $('.wc_ordo-yes-' + count).attr('checked', true);
                } else if (data['fields']['template_ordo'] === 'No') {
                    $('.wc_ordo-no-' + count).attr('checked', true);
                } else {
                    $('.wc_ordo-no-' + count).attr('checked', false);
                    $('.wc_ordo-yes-' + count).attr('checked', false);
                }
    
                $(`#woundCareDelete-${count}`).removeClass('d-none');
                
                $(`#woundCareDeleteBtn-${count}`).attr('data-id',data['fields']['id']);
                
            }else{
                $('#wound_template').val('');
                $('#wc_side-' + count + ' option:first').prop('selected', true);
                $('#wc_anatomical-' + count + ' option:first').prop('selected', true);
                $('#wc_location-' + count + ' option:first').prop('selected', true);
                $('#wc_wound_type-' + count + ' option:first').prop('selected', true);
                $('#wc_thickness-' + count + ' option:first').prop('selected', true);
                $('#wc_drainage_amount-' + count + ' option:first').prop('selected', true);
                $('#wc_drainage_description-' + count + ' option:first').prop('selected', true);
                $('#wc_surgically-' + count + ' option:first').prop('selected', true);
                $('.wc_undermining-no-' + count).attr('checked', false);
                $('.wc_undermining-yes-' + count).attr('checked', false);
                $('.wc_tunneling-yes-' + count).attr('checked', false);
                $('.wc_tunneling-no-' + count).attr('checked', false);
                $('.wc_ordo-yes-' + count).attr('checked', false);
                $('.wc_ordo-no-' + count).attr('checked', false);
                // add class to display none 
                $(`#woundCareDelete-${count}`).addClass('d-none');
            }
           
        },
    });
});

// delete template function 

// $(document).on('click',"#woundCareDeleteBtn", function(e){
// $(document).on('click', '[id^="woundCareDeleteBtn-"]', function () {
    $(document).on('click', '[id^="woundCareDeleteBtn-"]', function() {

    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {

    let woundId = $(this).attr('wound-card');
  
  
            $('#wound_template').val('');
                $('#wc_side-'+woundId+' option:first').prop('selected', true);
                $('#wc_anatomical-'+woundId+' option:first').prop('selected', true);
                $('#wc_location-'+woundId+' option:first').prop('selected', true);
                $('#wc_wound_type-'+woundId+' option:first').prop('selected', true);
                $('#wc_thickness-'+woundId+' option:first').prop('selected', true);
                $('#wc_drainage_amount-'+woundId+' option:first').prop('selected', true);
                $('#wc_drainage_description-'+woundId+' option:first').prop('selected', true);
                $('#wc_surgically-'+woundId+' option:first').prop('selected', true);
                $('.wc_undermining-no-'+woundId+'').attr('checked', false);
                $('.wc_undermining-yes-'+woundId+'').attr('checked', false);
                $('.wc_tunneling-yes-'+woundId+'').attr('checked', false);
                $('.wc_tunneling-no-'+woundId+'').attr('checked', false);
                $('.wc_ordo-yes-'+woundId+'').attr('checked', false);
                $('.wc_ordo-no-'+woundId+'').attr('checked', false);
                // add class to display none 
                $(`#woundCareDelete-${woundId}`).addClass('d-none');

                $(`#woundTempalte-${woundId} option:first`).prop('selected', true);
                $(`#woundTempalte-${woundId}`).select2();
        
                function reloadSelect2() {
                    $(`#woundTempalte-${woundId}`).select2('destroy');
                    $(`#woundTempalte-${woundId}`).select2();
                }
        
                reloadSelect2();
        }
    
})

$(document).on('click',"#wound-delete", function(e){
    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {
        let id = $(this).attr('data-id');
    let data = new FormData();
    data.append('template_type', 'Wound  Care Delete');
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
            $('#wound_template').val('');
            $('#wc_side-1 option:first').prop('selected', true);
            $('#wc_anatomical-1 option:first').prop('selected', true);
            $('#wc_location-1 option:first').prop('selected', true);
            $('#wc_wound_type-1 option:first').prop('selected', true);
            $('#wc_thickness-1 option:first').prop('selected', true);
            $('#wc_drainage_amount-1 option:first').prop('selected', true);
            $('#wc_drainage_description-1 option:first').prop('selected', true);
            $('#wc_surgically-1 option:first').prop('selected', true);
            $('.wc_undermining-no-1').attr('checked', false);
            $('.wc_undermining-yes-1').attr('checked', false);
            $('.wc_tunneling-yes-1').attr('checked', false);
            $('.wc_tunneling-no-1').attr('checked', false);
            $('.wc_ordo-yes-1').attr('checked', false);
            $('.wc_ordo-no-1').attr('checked', false);
            $('#wound_template_name option:first').prop('selected', true);
            $('#template_wc_side option:first').prop('selected', true);
            $('#template_wc_anatomical option:first').prop('selected', true);
            $('#template_wc_location option:first').prop('selected', true);
            $('#template_wc_wound_type option:first').prop('selected', true);
            $('#template_wc_thickness option:first').prop('selected', true);
            $('#template_wc_drainage_amount option:first').prop('selected', true);
            $('#template_wc_drainage_description option:first').prop('selected', true);
            $('#template_wc_surgically option:first').prop('selected', true);
            $('input[name=\'template_wc_undermining\']').attr('checked', false);
            $('input[name=\'template_wc_tunneling\']').attr('checked', false);
            $('input[name=\'template_wc_ordo\']').attr('checked', false);
            // $('#wc_volume').val('');
            $('input[id^="wc_volume-"]').val('');
            $('#wound_template').css('display', 'block');
            // add class to display none 
            $("#woundCareDelete").addClass('d-none');

            $('#wound_template_name option[value="' + id + '"]').remove();

            $('select[id^="woundTempalte-"] option[value="' + id + '"]').remove();

            $("#medicalInfoDelete").addClass('d-none');
            $('#wound-delete').css({
                color: 'darkgray',
                cursor: 'auto',
                pointerEvents: 'none',
                cursor: 'not-allowed'
            });
        },
    });
    
    } 

});


$(document).on('change', 'select[id^="wound_care_assessment-"]', function () {

    var wound_count = $(this).attr('data-wount');

    if (this.value === 'Select Template') {
        $('#wc_plan-' + wound_count).val('');
        $('#wc_medication-' + wound_count).val('');
        $('#wc_wound_icd-' + wound_count).val(null).trigger('change');
        $('#wc_icd-' + wound_count).val('');

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

                $('#wc_plan-' + wound_count).val(data['fields']['plan']);
                $('#wc_medication-' + wound_count).val(data['fields']['medication']);
                $('#wc_wound_icd-' + wound_count).
                    val(JSON.parse(data['fields']['ICD_10']).split(',')).
                    trigger('change');
                $('#wc_icd-' + wound_count).val(JSON.parse(data['fields']['ICD_10']).split(','));
            },
        });
    }
});

$(document).on('change', '.procedure_notes', function () {

    let number = $(this).data('count');
    let locationNumber = $(this).data('location');

    console.log('location number' + locationNumber);

    console.log('number' + number);

    if (this.value === '0' || this.value === 'Choose an Option') {
        $('#location_' + locationNumber + '_procedure_' + number).val('');
        $('#location_' + locationNumber + '_additional_' + number).val('');
        $('#location_' + locationNumber + '_cpt_' + number).val(null).trigger('change');
        $('#wc_cpt_' + locationNumber + '_code-' + number).val('');
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
                $('#location_' + locationNumber + '_cpt_' + number).select2();
                console.log(data['fields']['treatment_cpt_code'].split(','));
                $('#location_' + locationNumber + '_procedure_' + number).
                    val(data['fields']['treatment_procedure_note']);
                $('#location_' + locationNumber + '_additional_' + number).
                    val(data['fields']['treatment_additional_note']);
                $('#location_' + locationNumber + '_cpt_' + number).
                    val(data['fields']['treatment_cpt_code'].split(',')).
                    trigger('change');
                $('#wc_cpt_' + locationNumber + '_code-' + number).
                    val(data['fields']['treatment_cpt_code'].split(','));
                triggerInputForTextAreas();    

            },
        });
       
    }
});

function checkwounddata () {
    var user = $('#wound_template').val();

    if (user.length <= 0) {
        $('#wound_template_err').html('Template Name is required.').css('color', 'red');
        return true;
    } else {
        $('#wound_template_err').html('');
    }
}


$('.woundTemplate').on('click', function () {
    if (checkwounddata()) {

        Event.preventDefault();
    } else {

        let data = new FormData();
        data.append('template_type', 'Wound Template');
        data.append('template_name', document.getElementById('wound_template').value);
        data.append('template_side', $('#template_wc_side option:selected').text());
        data.append('template_anatomical_action', $('#template_wc_anatomical option:selected').text());
        data.append('template_location', $('#template_wc_location option:selected').text());
        data.append('template_wound_type', $('#template_wc_wound_type option:selected').text());
        data.append('template_wound_thickness', $('#template_wc_thickness option:selected').text());
        data.append('template_drainage_amount', $('#template_wc_drainage_amount option:selected').text());
        data.append('template_drainage_description', $('#template_wc_drainage_description option:selected').text());
        data.append('template_debrided_surgically_created', $('#template_wc_surgically option:selected').text());
        data.append('template_undermining', $('input[name=\'template_wc_undermining\']:checked').val());
        data.append('template_tunneling', $('input[name=\'template_wc_tunneling\']:checked').val());
        data.append('template_ordo', $('input[name=\'template_wc_ordo\']:checked').val());

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
                    data.append('template_type', 'Wound Template Update');
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

                            $('#wound_template_name').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['wound_template_name'] + '</option>');
                            $('.wound-template').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['wound_template_name'] + '</option>');
                        },
                    });
                    $('#woundCareModalCenter').modal('hide');

                    alert('Data Save Successfully...');
                }
                if (response == 'update success') {
                    $('#woundCareModalCenter').modal('hide');
                    alert('Data Save Successfully...');
                }
            },
        });
    }
});


$(document).on('change', '.cpt-code-change', function () {
    var wound_count = $(this).attr('data-wount');

    $('#wc_icd-' + wound_count).val($(this).val());
});

$(document).on('change', '.icd-code-change', function () {
    var wound_count = $(this).attr('data-wount');

    $('#wc_icd-' + wound_count).val($(this).val());
});

$(document).on('change', '.cpt_codes_all', function () {

    let number = $(this).data('count');
    let locationNumber = $(this).data('location');

    $('#wc_cpt_' + locationNumber + '_code-' + number).val($(this).val());

});

function switchTreatment(id) {
    $(`#firstTreatmentWound_${id}`).addClass('d-none');
    $(`#secondTreatmentWound_${id}`).removeClass('d-none');
}

function switchEditTreatment(id) {
    $(`#firstTreatmentEditWound_${id}`).addClass('d-none');
    $(`#secondTreatmentEditWound_${id}`).removeClass('d-none');
}

