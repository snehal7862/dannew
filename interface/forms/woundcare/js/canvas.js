var mousePressed = false;
var lastX, lastY;
var ctx = new Array();
var image = new Array();
var canvasPic = new Array();
var zone;
var cPushArray = new Array();
var cStep = new Array();

function InitThis (zone) {
    ctx[zone] = document.getElementById('myCanvas_' + zone).getContext('2d');

    $('#myCanvas_' + zone).on('touchstart', function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false, zone);
    });

    $('#myCanvas_' + zone).on('touchmove', function (e) {
        if (mousePressed) {
            e.preventDefault();
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true, zone);
        }
    });
    $('#myCanvas_' + zone).on('touchend', function (e) {
        mousePressed = false;
        cPush(zone);
    });

    $('#myCanvas_' + zone).mousedown(function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false, zone);
    });
    $('#myCanvas_' + zone).mousemove(function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true, zone);
        }
    });
    $('#myCanvas_' + zone).mouseup(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush(zone);
        }
    });

    $('#myCanvas_' + zone).mouseleave(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush(zone);
        }
    });
    drawImage(zone);
}

function drawImage (zone) {
    image[zone] = new Image();
    image[zone].src = $('#url_' + zone).val();
    $(image[zone]).on('load', function () {
        ctx[zone].drawImage(image[zone], 0, 0, 450, 225);
        cPush(zone);
    });
}

function Draw (x, y, isDown, zone) {
    if (isDown) {
        ctx[zone].beginPath();
        ctx[zone].strokeStyle = $('#selColor_' + zone).val();
        ctx[zone].lineWidth = $('#selWidth_' + zone).val();
        ctx[zone].lineJoin = 'round';
        ctx[zone].moveTo(lastX, lastY);
        ctx[zone].lineTo(x, y);
        ctx[zone].closePath();
        ctx[zone].stroke();
    }
    lastX = x;
    lastY = y;
}

function cPush (zone) {
    if (typeof (cStep[zone]) == 'undefined') { cStep[zone] = -1; }
    cStep[zone]++;
    if (typeof (cPushArray[zone]) == 'undefined') { cPushArray[zone] = new Array;}
    if (cStep[zone] < cPushArray[zone].length) { cPushArray[zone].length = cStep[zone]; }
    cPushArray[zone].push(document.getElementById('myCanvas_' + zone).toDataURL('image/jpeg'));
}

function cUndo (zone) {
    if (cStep[zone] > 0) {
        cStep[zone]--;
        canvasPic = new Image();
        canvasPic.src = cPushArray[zone][cStep[zone]];
        canvasPic.onload = function () { ctx[zone].drawImage(canvasPic, 0, 0); };
    }
}

function cRedo (zone) {
    if (cStep[zone] < cPushArray[zone].length - 1) {
        cStep[zone]++;
        canvasPic = new Image();
        canvasPic.src = cPushArray[zone][cStep[zone]];
        canvasPic.onload = function () { ctx[zone].drawImage(canvasPic, 0, 0); };
    }
}

function cReload (zone) {
    $('#url_' + zone).val($('#base_url_' + zone).val());
    drawImage(zone);
}

function cReplace (zone) {
    $('#' + zone + '_olddrawing').addClass('nodisplay');
    $('#' + zone + '_canvas').show();
    canvasPic = new Image();
    canvasPic.src = $('#url_' + zone).val();
    ctx[zone].drawImage(canvasPic, 0, 0);
    cPush(zone);
    drawImage(zone);
}

function cBlank (zone) {
    $('#url_' + zone).val('../../forms/eye_mag/images/BLANK_BASE.png');
    drawImage(zone);
    cPush(zone);
}

InitThis('CLOCK');

$('[id^=\'myCanvas_\']').on('mouseout', function () {
    var zone = this.id.match(/myCanvas_(.*)/)[1];
});
$('[id^=\'Undo_\']').on('click', function () {
    var zone = this.id.match(/Undo_Canvas_(.*)/)[1];
});
$('[id^=\'Redo_\']').on('click', function () {
    var zone = this.id.match(/Redo_Canvas_(.*)/)[1];
});
$('[id^=\'Clear_\']').on('click', function () {
    var zone = this.id.match(/Clear_Canvas_(.*)/)[1];
});
$('[id^=\'Blank_\']').on('click', function () {

    var zone = this.id.match(/Blank_Canvas_(.*)/)[1];
    $('#url_' + zone).val('../../forms/eye_mag/images/BLANK_BASE.png');
    //canvas.renderAll();
    drawImage(zone);
});

$('[id^=\'sketch_sizes_\']').click(function () {
    var zone = this.id.match(/sketch_sizes_(.*)_/)[1];
    $('[id^=\'sketch_sizes_' + zone + '\']').css('background', '').css('border-bottom', '');
    $(this).css('border-bottom', '2pt solid black');
});

$('[id^=\'sketch_tools_\']').click(function () {

    var zone = this.id.match(/sketch_tools_(.*)_/)[1];
    $('[id^=\'sketch_tools_' + zone + '\']').css('height', '30px');
    $(this).css('height', '50px');
    $('#sketch_tool_' + zone + '_color').
        css('background-image', '').
        css('background-color', $('#selColor_' + zone).val());
});

$('#DrawClockDynamicModal').on('hidden.bs.modal', function () {
    cReload('CLOCK');
});

// $(document).on('click','.clock-model-id-1',function () {
//     $('#DrawClockDynamicModal').modal('show');
//     $('.clock_id').val(1);
// });

// $(document).on('click','.clock-model-id-2',function () {
//     $('#DrawClockDynamicModal').modal('show');
//     $('.clock_id').val(2);
// });

var mousePressed = false;
var lastX, lastY;
var ctx = new Array();
var image = new Array();
var canvasPic = new Array();
var zone;
var cPushArray = new Array();
var cStep = new Array();

function InitThis (zone) {
    ctx[zone] = document.getElementById('myCanvas_' + zone).getContext('2d');

    $('#myCanvas_' + zone).on('touchstart', function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false, zone);
    });

    $('#myCanvas_' + zone).on('touchmove', function (e) {
        if (mousePressed) {
            e.preventDefault();
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true, zone);
        }
    });
    $('#myCanvas_' + zone).on('touchend', function (e) {
        mousePressed = false;
        cPush(zone);
    });

    $('#myCanvas_' + zone).mousedown(function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false, zone);
    });
    $('#myCanvas_' + zone).mousemove(function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true, zone);
        }
    });
    $('#myCanvas_' + zone).mouseup(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush(zone);
        }
    });

    $('#myCanvas_' + zone).mouseleave(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush(zone);
        }
    });
    drawImage(zone);
}

function drawImage (zone) {
    image[zone] = new Image();
    image[zone].src = $('#url_' + zone).val();
    $(image[zone]).on('load', function () {
        ctx[zone].drawImage(image[zone], 0, 0, 450, 225);
        cPush(zone);
    });
}

function Draw (x, y, isDown, zone) {
    if (isDown) {
        ctx[zone].beginPath();
        ctx[zone].strokeStyle = $('#selColor_' + zone).val();
        ctx[zone].lineWidth = $('#selWidth_' + zone).val();
        ctx[zone].lineJoin = 'round';
        ctx[zone].moveTo(lastX, lastY);
        ctx[zone].lineTo(x, y);
        ctx[zone].closePath();
        ctx[zone].stroke();
    }
    lastX = x;
    lastY = y;
}

function cPush (zone) {
    if (typeof (cStep[zone]) == 'undefined') { cStep[zone] = -1; }
    cStep[zone]++;
    if (typeof (cPushArray[zone]) == 'undefined') { cPushArray[zone] = new Array;}
    if (cStep[zone] < cPushArray[zone].length) { cPushArray[zone].length = cStep[zone]; }
    cPushArray[zone].push(document.getElementById('myCanvas_' + zone).toDataURL('image/jpeg'));
}

function cUndo (zone) {
    if (cStep[zone] > 0) {
        cStep[zone]--;
        canvasPic = new Image();
        canvasPic.src = cPushArray[zone][cStep[zone]];
        canvasPic.onload = function () { ctx[zone].drawImage(canvasPic, 0, 0); };
    }
}

function cRedo (zone) {
    if (cStep[zone] < cPushArray[zone].length - 1) {
        cStep[zone]++;
        canvasPic = new Image();
        canvasPic.src = cPushArray[zone][cStep[zone]];
        canvasPic.onload = function () { ctx[zone].drawImage(canvasPic, 0, 0); };
    }
}

function cReload (zone) {
    $('#url_' + zone).val($('#base_url_' + zone).val());
    drawImage(zone);
}

function cReplace (zone) {
    $('#' + zone + '_olddrawing').addClass('nodisplay');
    $('#' + zone + '_canvas').show();
    canvasPic = new Image();
    canvasPic.src = $('#url_' + zone).val();
    ctx[zone].drawImage(canvasPic, 0, 0);
    cPush(zone);
    drawImage(zone);
}

function cBlank (zone) {
    $('#url_' + zone).val('../../forms/eye_mag/images/BLANK_BASE.png');
    drawImage(zone);
    cPush(zone);
}

InitThis('CLOCK');

$('[id^=\'myCanvas_\']').on('mouseout', function () {
    var zone = this.id.match(/myCanvas_(.*)/)[1];
});
$('[id^=\'Undo_\']').on('click', function () {
    var zone = this.id.match(/Undo_Canvas_(.*)/)[1];
});
$('[id^=\'Redo_\']').on('click', function () {
    var zone = this.id.match(/Redo_Canvas_(.*)/)[1];
});
$('[id^=\'Clear_\']').on('click', function () {
    var zone = this.id.match(/Clear_Canvas_(.*)/)[1];
});
$('[id^=\'Blank_\']').on('click', function () {

    var zone = this.id.match(/Blank_Canvas_(.*)/)[1];
    $('#url_' + zone).val('../../forms/eye_mag/images/BLANK_BASE.png');
    //canvas.renderAll();
    drawImage(zone);
});

$('[id^=\'sketch_sizes_\']').click(function () {
    var zone = this.id.match(/sketch_sizes_(.*)_/)[1];
    $('[id^=\'sketch_sizes_' + zone + '\']').css('background', '').css('border-bottom', '');
    $(this).css('border-bottom', '2pt solid black');
});

$('[id^=\'sketch_tools_\']').click(function () {

    var zone = this.id.match(/sketch_tools_(.*)_/)[1];
    $('[id^=\'sketch_tools_' + zone + '\']').css('height', '30px');
    $(this).css('height', '50px');
    $('#sketch_tool_' + zone + '_color').
        css('background-image', '').
        css('background-color', $('#selColor_' + zone).val());
});

$('#DrawClockDynamicModal').on('hidden.bs.modal', function () {
    cReload('CLOCK');
});

$(document).on('click','.clock-model-id-1',function () {
    $('#DrawClockDynamicModal').modal('show');
    $('.clock_id').val($(this).data('value'));
    $('.image_id').val($(this).data('image'));
});

$(document).on('click','.clock-model-id-2',function () {
    $('#DrawClockDynamicModal').modal('show');
    $('.clock_id').val($(this).data('value'));
    $('.image_id').val($(this).data('image'));
});