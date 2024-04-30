$('.key-medical').on('change', function () {

    if (this.value == '0' || this.value == 'Select Template') {
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
        $('#medical-delete').css({
            color: 'darkgray',
            cursor: 'auto',
            pointerEvents: 'none',
            cursor: 'not-allowed'
        });
    } else {
        $('#template').css('display', 'none');
        $('#medical-delete').css({
            color: '#5DBDCE',
            cursor: 'pointer',
            pointerEvents:'auto'
        });
        
        let data = new FormData();
        data.append('template_type', 'Medical Information');
        data.append('template_id', jQuery('#template_name option:selected').val());
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

                $('#template').val(data['fields']['template_name']);
                $('#template_hip').val(data['fields']['template_hip']);
                $('#template_chief_complaint').val(data['fields']['template_chief_complaint']);
                $('#template_current_medication').val(data['fields']['template_current_medication']);
                $('#template_medical_history').val(data['fields']['template_medical_history']);
                $('#template_allergies').val(data['fields']['template_allergies']);
                $('#template_surgical_history').val(data['fields']['template_surgical_history']);
                $('#template_social_history').val(data['fields']['template_social_history']);
                $('#template_family_history').val(data['fields']['template_family_history']);
                $('#template_ros').val(data['fields']['template_ros']);
                $('#medical-delete').attr('data-id',data['fields']['id']);
            },
        });
    }
});

$('.medicalInformation').on('click', function (e) {
    if (checkdata()) {

        e.preventDefault();
    } else {
        let data = new FormData();
        data.append('template_type', 'Medical Information');
        data.append('template_name', document.getElementById('template').value);
        data.append('template_chief_complaint', document.getElementById('template_chief_complaint').value);
        data.append('template_hip', document.getElementById('template_hip').value);
        data.append('template_current_medication', document.getElementById('template_current_medication').value);
        data.append('template_medical_history', document.getElementById('template_medical_history').value);
        data.append('template_allergies', document.getElementById('template_allergies').value);
        data.append('template_surgical_history', document.getElementById('template_surgical_history').value);
        data.append('template_social_history', document.getElementById('template_social_history').value);
        data.append('template_family_history', document.getElementById('template_family_history').value);
        data.append('template_ros', document.getElementById('template_ros').value);

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
                    data.append('template_type', 'Medical Information Update');
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

                            $('#medical_info').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['template_name'] + '</option>');
                            $('#template_name').
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

function checkdata () {
    var user = $('#template').val();

    if (user.length <= 0) {
        $('#template_err').html('Template Name is required.').css('color', 'red');
        return true;
    } else {
        $('#template_err').html('');
    }
}

$('.key1').change(function () {
    var medical_info = $(this).val();
    if (medical_info == 'Select Template') {
        $('#wc_hpi').val('');
    }
    $('#medicalInformation').addClass('show');
    let data = new FormData();
    data.append('template_type', 'Medical Information');
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

        
            var hpi_length = $('#wc_hpi').val();

            if (medical_info == 'Select Template' && hpi_length.length == 0) {
                $('#wc_hpi').val('');
            } else if (hpi_length.length == 0) {
                $('#wc_hpi').val('\u2022 ' + data['fields']['template_hip']);
            } else {
                $('#wc_hpi').val(hpi_length + '\n\u2022 ' + data['fields']['template_hip']);
                $('#wc_hpi').scrollTop($('#wc_hpi')[0].scrollHeight);
            
                var wc_hpi = $('#wc_hpi')[0];
                wc_hpi.style.height = 'auto';
                wc_hpi.style.height = (wc_hpi.scrollHeight) + 'px';
            }

            $('#wc_complaint').val(data['fields']['template_chief_complaint']);
            $('#wc_current_medication').val(data['fields']['template_current_medication']);
            $('#wc_medical_history').val(data['fields']['template_medical_history']);
            $('#wc_allergies').val(data['fields']['template_allergies']);
            $('#wc_surgical_history').val(data['fields']['template_surgical_history']);
            $('#wc_social').val(data['fields']['template_social_history']);
            $('#wc_family').val(data['fields']['template_family_history']);
            $('#wc_ros').val(data['fields']['template_ros']);

            $("#medicalInfoDelete").removeClass('d-none');
        
            $('#medicalInfoDeleteBtn').attr('data-id',data['fields']['id']);

            triggerInputForTextAreas();

        }else{
            $("#medicalInfoDelete").addClass('d-none');
            $('#wc_complaint').val('');
            $('#wc_hpi').val('');
            $('#wc_current_medication').val('');
            $('#wc_medical_history').val('');
            $('#wc_allergies').val('');
            $('#wc_surgical_history').val('');
            $('#wc_social').val('');
            $('#wc_family').val('');
            $('#wc_ros').val('');   
            
            triggerInputForTextAreas();
        }
        },
    });

   
});

$(document).on('click',"#medicalInfoDeleteBtn", function(e){

    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {

        $('#wc_complaint').val('');
        $('#wc_hpi').val('');
        $('#wc_current_medication').val('');
        $('#wc_medical_history').val('');
        $('#wc_allergies').val('');
        $('#wc_surgical_history').val('');
        $('#wc_social').val('');
        $('#wc_family').val('');
        $('#wc_ros').val('');

        $('#medical_info option:first').prop('selected', true);
        $('#medical_info').select2();

        function reloadSelect2() {
            $('#medical_info').select2('destroy');
            $('#medical_info').select2();
        }

        reloadSelect2();

        $("#medicalInfoDelete").addClass('d-none'); 
    } 

    
})


$(document).on('click',"#medical-delete", function(e){
    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {
        let id = $(this).attr('data-id');
    let data = new FormData();
    data.append('template_type', 'Medical Information Delete');
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
            $('#wc_complaint').val('');
            $('#wc_hpi').val('');
            $('#wc_current_medication').val('');
            $('#wc_medical_history').val('');
            $('#wc_allergies').val('');
            $('#wc_surgical_history').val('');
            $('#wc_social').val('');
            $('#wc_family').val('');
            $('#wc_ros').val('');
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

            $('#medical_info option[value="' + id + '"]').remove();
            $('#template_name option[value="' + id + '"]').remove();

            $("#medicalInfoDelete").addClass('d-none');
            $('#medical-delete').css({
                color: 'darkgray',
                cursor: 'auto',
                pointerEvents: 'none',
                cursor: 'not-allowed'
            });
        },
    });
    
    } 

});