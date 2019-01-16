var $ = jQuery;
jQuery(document).ready(function () {
    $("[name=delete]").on('click', function () {
        if (confirm('Realmente deseas eliminar este registro?') === true) {
            delete_booking($(this));
        }
    });
});
function delete_booking(button) {
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            'action': 'delete_booking',
            'booking': button.attr('data-booking')
        },
        success: function (res) {
            if (res.id && res.id > 0) {
                location.reload();
            }
        }
    });
}