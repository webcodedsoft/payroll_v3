$(".switch, .radio").each(function() {
    var intElem = $(this);
    intElem.on('click', function() {
        intElem.addClass('interactive-effect');
        setTimeout(function() {
            intElem.removeClass('interactive-effect');
        }, 400);
    });
});