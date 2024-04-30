$(document).on('click', function (event) {
    var $clickedElement = $(event.target);
    var dataId = $clickedElement.attr('data-id');     

    var isChecked = $clickedElement.is(":checked");

    if (dataId == 0) {
        $('.exam-physical-copy').prop('checked', isChecked);
        $('#physicalExamCopyBody').collapse('show');
        $('#physical-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    } else {
        $(`.exam-physical-copy-${dataId}`).prop('checked', isChecked);
        $(`#physicalExamCopyBody_${dataId}`).collapse('show');
        $(`#physical-collapse-icon-${dataId}`).removeClass('fa-plus-square').addClass('fa-minus-square');
    }
});

$(document).on('change', function (event) {

    var $clickedElement = $(event.target);

    var dataId = $clickedElement.attr('data-check');

    if (dataId == 0) {
        var allChecked = $('.exam-physical-copy:checked').length === $('.exam-physical-copy').length;
        $('#physicalExamCopyCheckAll').prop('checked', allChecked);
    } else {
        var allChecked = $(`.exam-physical-copy-${dataId}:checked`).length === $(`.exam-physical-copy-${dataId}`).length;
        $(`#physicalExamCopyCheckAll_${dataId}`).prop('checked', allChecked);
    }
});


$('#physicalExamCopyModal').on('hidden.bs.modal', function (e) {
    $(this).find(':checkbox').prop('checked', false);
    $(this).find(':radio').prop('checked', false);
    $('#physical-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    $('#physicalExamCopyBody').collapse('show');

});

$(document).on('click', function (event) {

    var $clickedElement = $(event.target);

    if ($clickedElement.hasClass('fa-plus-square')) {

        $clickedElement.removeClass('fa-plus-square').addClass('fa-minus-square');
    } else if ($clickedElement.hasClass('fa-minus-square')) {

        $clickedElement.removeClass('fa-minus-square').addClass('fa-plus-square');
    }
});

