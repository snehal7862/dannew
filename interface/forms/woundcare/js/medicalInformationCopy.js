$(document).on('click', function (event) {
    var $clickedElement = $(event.target);
    var dataId = $clickedElement.attr('data-medical-id');     

    var isChecked = $clickedElement.is(":checked");

    if (dataId == 0) {
        $('.modical-information-copy').prop('checked', isChecked);
        $('#medicalInformationCopyBody').collapse('show');
        $('#medical-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    } else {
        $(`.modical-information-copy-${dataId}`).prop('checked', isChecked);
        $(`#medicalInformationCopyBody_${dataId}`).collapse('show');
        $(`#medical-collapse-icon-${dataId}`).removeClass('fa-plus-square').addClass('fa-minus-square');
    }
});



$(document).on('change', function (event) {

    var $clickedElement = $(event.target);

    var dataId = $clickedElement.attr('data-medical');

    if (dataId == 0) {

        $('#medicalInformationCopyCheckAll').prop('checked', allChecked);

        var allChecked = $('.modical-information-copy:checked').length === $('.modical-information-copy').length;
        $('#medicalInformationCopyCheckAll').prop('checked', allChecked);
    } else {
        var allChecked = $(`.modical-information-copy-${dataId}:checked`).length === $(`.modical-information-copy-${dataId}`).length;
        $(`#medicalInformationCopyCheckAll_${dataId}`).prop('checked', allChecked);
    }
});



$('#medicalInformationCopyModal').on('hidden.bs.modal', function (e) {
            $(this).find(':checkbox').prop('checked', false);
            $(this).find(':radio').prop('checked', false);
            $('#medical-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
             $('#medicalInformationCopyBody').collapse('show');
       
});