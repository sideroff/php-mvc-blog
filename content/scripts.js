$(document).ready(function() {
    $gosho = $('div')
            .filter(function() {
                return  this.className.match(/(?:^info|^error|^success)Message$/);
        });
    $gosho.click(function () {
        $(this).fadeOut();
    });
    $gosho.each(function (index, value) {
        setTimeout(function () {
            $(value).fadeOut();
        },$(value).attr("data-timeout"))
    });
});
