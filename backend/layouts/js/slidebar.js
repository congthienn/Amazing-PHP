$(document).ready(function () {
    $('.slider_menu--header').click(function () {
        var show_menu = $("#check_show_menu").prop("checked");
        if (show_menu == true) {
            $(".icon_down").removeClass("fa-caret-up");
            $(".icon_down").addClass("fa-caret-down");
            $("#menu_container").addClass('hide_menu');
        } else {
            $(".icon_down").removeClass("fa-caret-down");
            $(".icon_down").addClass("fa-caret-up");
            $("#menu_container").removeClass('hide_menu');
        }
    });
});
