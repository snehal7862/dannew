$('.physicalExamKey').on('change', function () {
    
    if (this.value == '0' || this.value == 'Open this select menu') {
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
        $('#physical-delete').css({
            color: 'darkgray',
            cursor: 'auto',
            pointerEvents: 'none',
            cursor: 'not-allowed'
        });
    } else {
        $('#template_exam_name').css('display', 'none');
        $('#physical-delete').css({
            color: '#5DBDCE',
            cursor: 'pointer',
            pointerEvents:'auto'
        });
        
        let data = new FormData();
        data.append('template_type', 'Physical Exam');
        data.append('template_id', jQuery('#exam_name option:selected').val());
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

                $('#template_exam_name').val(data['fields']['physical_exam_name']);
                $('#template_general').val(data['fields']['physical_exam_general']);
                $('#template_head').val(data['fields']['physical_exam_head']);
                $('#template_eyes').val(data['fields']['physical_exam_eyes']);
                $('#template_nose').val(data['fields']['physical_exam_nose']);
                // $('#template_throat').val(data['fields']['physical_exam_throat']);
                $('#template_ears').val(data['fields']['physical_exam_ears']);
                $('#template_oral_cavity').val(data['fields']['physical_exam_oral_cavity']);
                $('#template_neck').val(data['fields']['physical_exam_neck']);
                $('#template_skin_history').val(data['fields']['physical_exam_skin']);
                $('#template_lungs').val(data['fields']['physical_exam_lungs']);
                $('#template_abdomen').val(data['fields']['physical_exam_abdomen']);
                $('#template_extemities').val(data['fields']['physical_exam_extemities']);
                $('#template_heart').val(data['fields']['physical_exam_heart']);
                $('#template_back').val(data['fields']['physical_exam_back']);
                $('#template_pelvic').val(data['fields']['physical_exam_pelvic']);
                $('#template_breast').val(data['fields']['physical_exam_breast']);
                $('#template_genitourinary').val(data['fields']['physical_exam_genitourinary']);
                $('#template_neurologic').val(data['fields']['physical_exam_neurologic']);
                $('#template_musculoskeletal').val(data['fields']['physical_exam_musculoskeletal']);
                $('#physical-delete').attr('data-id',data['fields']['id']);
            },
        });
    }
});

$('.physicalExam').on('click', function () {
    if (checkPhysicalExam()) {

    } else {
        let data = new FormData();
        data.append('template_type', 'Physical Exam');
        data.append('physical_exam_name', document.getElementById('template_exam_name').value);
        data.append('template_general', document.getElementById('template_general').value);
        data.append('template_head', document.getElementById('template_head').value);
        data.append('template_eyes', document.getElementById('template_eyes').value);
        data.append('template_nose', document.getElementById('template_nose').value);
        // data.append("template_throat", document.getElementById('template_throat').value);
        data.append('template_ears', document.getElementById('template_ears').value);
        data.append('template_oral_cavity', document.getElementById('template_oral_cavity').value);
        data.append('template_neck', document.getElementById('template_neck').value);
        data.append('template_skin', document.getElementById('template_skin').value);
        data.append('template_lungs', document.getElementById('template_lungs').value);
        data.append('template_abdomen', document.getElementById('template_abdomen').value);
        data.append('template_extemities', document.getElementById('template_extemities').value);
        data.append('template_heart', document.getElementById('template_heart').value);
        data.append('template_back', document.getElementById('template_back').value);
        data.append('template_pelvic', document.getElementById('template_pelvic').value);
        data.append('template_breast', document.getElementById('template_breast').value);
        data.append('template_genitourinary', document.getElementById('template_genitourinary').value);
        data.append('template_neurologic', document.getElementById('template_neurologic').value);
        data.append('template_musculoskeletal', document.getElementById('template_musculoskeletal').value);

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
                    data.append('template_type', 'Physical Exam Update');
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

                            $('#physical_exam').
                                append('<option value="' + data['fields']['id'] + '">' +
                                    data['fields']['physical_exam_name'] + '</option>');
                                    $('#exam_name').
                                    append('<option value="' + data['fields']['id'] + '">' +
                                        data['fields']['physical_exam_name'] + '</option>');
                        },
                    });
                    $('.modal').modal('hide');

                    alert('Data Save Successfully...');
                }
                if (response == 'update success') {
                    $('.modal').modal('hide');
                    alert('Data Update Successfully...');
                }
            },
        });

    }
});

function checkPhysicalExam () {
    var user = $('#template_exam_name').val();

    if (user.length <= 0) {
        $('#template_exam_name_err').html('Template Name is required.').css('color', 'red');
        return true;
    } else {
        $('#template_exam_name_err').html('');
    }
}

$('.physical').change(function () {
    $('#physicalExam').addClass('show');
    let data = new FormData();
    data.append('template_type', 'Physical Exam');
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
                
                $('#wc_general').val(data['fields']['physical_exam_general']);
                $('#wc_head').val(data['fields']['physical_exam_head']);
                $('#wc_eyes').val(data['fields']['physical_exam_eyes']);
                $('#wc_nose').val(data['fields']['physical_exam_nose']);
                $('#wc_throat').val(data['fields']['physical_exam_throat']);
                $('#wc_ears').val(data['fields']['physical_exam_ears']);
                $('#wc_oral').val(data['fields']['physical_exam_oral_cavity']);
                $('#wc_neck').val(data['fields']['physical_exam_neck']);
                $('#wc_skin').val(data['fields']['physical_exam_skin']);
                $('#wc_lungs').val(data['fields']['physical_exam_lungs']);
                $('#wc_abdomen').val(data['fields']['physical_exam_abdomen']);
                $('#wc_extremities').val(data['fields']['physical_exam_extemities']);
                $('#wc_heart').val(data['fields']['physical_exam_heart']);
                $('#wc_back').val(data['fields']['physical_exam_back']);
                $('#wc_pelvic').val(data['fields']['physical_exam_pelvic']);
                $('#wc_breast').val(data['fields']['physical_exam_breast']);
                $('#wc_genitourinary').val(data['fields']['physical_exam_genitourinary']);
                $('#wc_neurologic').val(data['fields']['physical_exam_neurologic']);
                $('#wc_musculoskeletal').val(data['fields']['physical_exam_musculoskeletal']);
    
                $("#physicalExamDelete").removeClass('d-none');
            
                $('#physicalExamDeleteBtn').attr('data-id',data['fields']['id']);

                triggerInputForTextAreas();

            }else{

                $('#wc_general').val('');
                $('#wc_head').val('');
                $('#wc_eyes').val('');
                $('#wc_nose').val('');
                $('#wc_throat').val('');
                $('#wc_ears').val('');
                $('#wc_oral').val('');
                $('#wc_neck').val('');
                $('#wc_skin').val('');
                $('#wc_lungs').val('');
                $('#wc_abdomen').val('');
                $('#wc_extremities').val('');
                $('#wc_heart').val('');
                $('#wc_back').val('');
                $('#wc_pelvic').val('');
                $('#wc_breast').val('');
                $('#wc_genitourinary').val('');
                $('#wc_neurologic').val('');
                $('#wc_musculoskeletal').val('');
    
                $("#physicalExamDelete").addClass('d-none');
                
                triggerInputForTextAreas();
            }


        },
    });
});


$(document).on('click',"#physicalExamDeleteBtn", function(e){

    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {
            $('#wc_general').val('');
            $('#wc_head').val('');
            $('#wc_eyes').val('');
            $('#wc_nose').val('');
            $('#wc_throat').val('');
            $('#wc_ears').val('');
            $('#wc_oral').val('');
            $('#wc_neck').val('');
            $('#wc_skin').val('');
            $('#wc_lungs').val('');
            $('#wc_abdomen').val('');
            $('#wc_extremities').val('');
            $('#wc_heart').val('');
            $('#wc_back').val('');
            $('#wc_pelvic').val('');
            $('#wc_breast').val('');
            $('#wc_genitourinary').val('');
            $('#wc_neurologic').val('');
            $('#wc_musculoskeletal').val('');

            $('#physical_exam option:first').prop('selected', true);
            $('#physical_exam').select2();
    
            function reloadSelect2() {
                $('#physical_exam').select2('destroy');
                $('#physical_exam').select2();
            }
    
            reloadSelect2();

            $("#physicalExamDelete").addClass('d-none');

    } 

    
})


$(document).on('click',"#physical-delete", function(e){
    var confirmation = confirm("Are you sure you want to delete this item?");

    if (confirmation) {
        let id = $(this).attr('data-id');
    let data = new FormData();
    data.append('template_type', 'Physical Exam Delete');
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
            $('#wc_general').val('');
            $('#wc_head').val('');
            $('#wc_eyes').val('');
            $('#wc_nose').val('');
            $('#wc_throat').val('');
            $('#wc_ears').val('');
            $('#wc_oral').val('');
            $('#wc_neck').val('');
            $('#wc_skin').val('');
            $('#wc_lungs').val('');
            $('#wc_abdomen').val('');
            $('#wc_extremities').val('');
            $('#wc_heart').val('');
            $('#wc_back').val('');
            $('#wc_pelvic').val('');
            $('#wc_breast').val('');
            $('#wc_genitourinary').val('');
            $('#wc_neurologic').val('');
            $('#wc_musculoskeletal').val('');
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
            $('.physicalExamKey option[value="' + id + '"]').remove();
            $('#physical_exam option[value="' + id + '"]').remove();
            $("#physicalExamDelete").addClass('d-none');
           

            $('#physical-delete').css({
                color: 'darkgray',
                cursor: 'auto',
                pointerEvents: 'none',
                cursor: 'not-allowed'
            });
        },
    });
    
    } 

});