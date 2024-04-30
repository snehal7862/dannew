
var isCheckedArray = [];
$(document).on('click', function (event) {
    var $clickedElement = $(event.target);
    var dataId = $clickedElement.attr('data-wound-id');     

    var isChecked = $clickedElement.is(":checked");
    
    if (dataId == 0) {
        isCheckedArray.push(dataId);
        $('.wound-care-copy').prop('checked', isChecked);
        $('#woundCareCopyBody').collapse('show');
        $('#wound-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    } else {
        $(`.wound-care-copy-${dataId}`).prop('checked', isChecked);
        $(`#woundCareCopyBody_${dataId}`).collapse('show');
        $(`#wound-collapse-icon-${dataId}`).removeClass('fa-plus-square').addClass('fa-minus-square');
        isCheckedArray.push(dataId);
    }
   

    var newArrayWithoutUndefined = isCheckedArray.filter(function (value) {
        return value !== undefined;
      });

    unCheckAllrelated(newArrayWithoutUndefined, dataId);
});


function unCheckAllrelated(isCheckedArray, dataId){
   
    isCheckedArray.forEach(element => {
        if(dataId !== element){
            if(element == 0){
                $('.wound-care-copy').prop('checked', false);
                $(`#woundCareCopyCheckAll`).prop('checked', false);
            }
            else
                $(`.wound-care-copy-${element}`).prop('checked', false);
                $(`#woundCareCopyCheckAll_${element}`).prop('checked', false);
        }
    
    });
}


$(document).on('change', function (event) {

    var $clickedElement = $(event.target);

    var dataId = $clickedElement.attr('data-wound');

    if (dataId == 0) {
        var allChecked = $('.wound-care-copy:checked').length === $('.wound-care-copy').length;
        $('#woundCareCopyCheckAll').prop('checked', allChecked);
    } else {
        var allChecked = $(`.wound-care-copy-${dataId}:checked`).length === $(`.wound-care-copy-${dataId}`).length;
        $(`#woundCareCopyCheckAll_${dataId}`).prop('checked', allChecked);
    }
});


$('#woundCareCopyModal').on('hidden.bs.modal', function (e) {
    $(this).find(':checkbox').prop('checked', false);
    $(this).find(':radio').prop('checked', false);
    $('#wound-collapse-icon').removeClass('fa-plus-square').addClass('fa-minus-square');
    $('#woundCareCopyBody').collapse('show');

});



