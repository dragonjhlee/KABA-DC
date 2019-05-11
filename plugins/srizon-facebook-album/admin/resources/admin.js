jQuery(document).ready(function () {
    jQuery('h3.hndle2, div.handlediv').click(function () {
        jQuery(this).parent().toggleClass('closed');
    });
    jQuery('.srz-cond').srz_conditionize();
});

(function ($) {
    $.fn.srz_conditionize = function (options) {

        var settings = $.extend({
            hideJS: true
        }, options);

        $.fn.showOrHide = function (listenTo, listenFor, $section) {
            var listenForArray = listenFor.toString().split(',');
            for (var i = 0; i < listenForArray.length; i++) {
                listenForArray[i] = listenForArray[i].trim();
            }
            if ($(listenTo).is(':hidden')) {
                $section.slideUp(50, triggernext);
            }
            else if ($(listenTo).is('select, input[type=text]') && listenForArray.indexOf($(listenTo).val()) != -1) {
                $section.slideDown(50, triggernext);
            }
            else if (listenForArray.indexOf($(listenTo + ":checked").val()) != -1) {
                $section.slideDown(50, triggernext);
            }
            else {
                $section.slideUp(50, triggernext);
            }

            function triggernext() {
                if ($section.data('cond-option')) {
                    $section.find('input').trigger('change');
                }
            }

        };

        return this.each(function () {
            var listenTo = "[class=" + $(this).data('cond-option') + "]";
            var listenFor = $(this).data('cond-value');
            var $section = $(this);


            //Set up event listener
            $(listenTo).on('change', function () {
                $.fn.showOrHide(listenTo, listenFor, $section);
            });
            //If setting was chosen, hide everything first...
            if (settings.hideJS) {
                $(this).hide();
            }
            //Show based on current value on page load
            $.fn.showOrHide(listenTo, listenFor, $section);
        });
    }
}(jQuery));