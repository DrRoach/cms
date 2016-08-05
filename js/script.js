$(document).ready(function() {
    switchContentType();
    $('form select[name="type"]').on('change', switchContentType);
});

function switchContentType() {
    var val = $('form select[name="type"]').val();

    if (val == "text") {
        $('#imageContent').hide();
        $('#textContent').show();
    } else {
        $('#textContent').hide();
        $('#imageContent').show();
    }
}