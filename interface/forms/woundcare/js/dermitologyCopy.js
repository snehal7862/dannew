$(document).on('click', function (event) {
    var $clickedElement = $(event.target);
    var dataId = $clickedElement.attr('data-dermitology-id');     

    var isChecked = $clickedElement.is(":checked");
    
    if (dataId == 0) {
        $('.dermitology-copy').prop('checked', isChecked);
        $('#dermitologyCopyBody').collapse('show');
        $('#dermitology-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    } else {
        $(`.dermitology-copy-${dataId}`).prop('checked', isChecked);
        $(`#dermitologyCopyBody_${dataId}`).collapse('show');
        $(`#dermitology-collapse-icon-${dataId}`).removeClass('fa-plus-square').addClass('fa-minus-square');
    }
});

$(document).on('change', function (event) {

    var $clickedElement = $(event.target);

    var dataId = $clickedElement.attr('data-dermitology');

    if (dataId == 0) {
        var allChecked = $('.dermitology-copy:checked').length === $('.dermitology-copy').length;
        $('#dermitologyCopyCheckAll').prop('checked', allChecked);
    } else {
        var allChecked = $(`.dermitology-copy-${dataId}:checked`).length === $(`.dermitology-copy-${dataId}`).length;
        $(`#dermitologyCopyCheckAll_${dataId}`).prop('checked', allChecked);
    }
});


$('#dermitologyCopyModal').on('hidden.bs.modal', function (e) {
    $(this).find(':checkbox').prop('checked', false);
    $(this).find(':radio').prop('checked', false);
    $('#dermitology-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    $('#dermitologyCopyBody').collapse('show');

});


