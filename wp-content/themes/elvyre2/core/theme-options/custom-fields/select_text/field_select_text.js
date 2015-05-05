/* global redux_change */
(function($) {
    "use strict";

    $.redux = $.redux || {};

    $(document).ready(function() {
        //multi text functionality
        $.redux.select_text();
    });

    $.redux.select_text = function() {
        var default_params;

        $('select.select-text-select').each(function() {
            default_params = {
                width: 'resolve',
                triggerChange: true,
                allowClear: true,
                placeholder: "Select icon"
            };

            default_params = $.extend({}, {formatResult: addIconToSelect, formatSelection: addIconToSelect, escapeMarkup: function(m) {
                    return m;
                }}, default_params);

            $(this).select2(default_params);
        });

        $('.redux-select-text-remove').live('click', function() {
            redux_change($(this));
            $(this).prev('input[type="text"]').val('');
            $(this).parent().slideUp('medium', function() {
                $(this).remove();
            });
        });

        $('.redux-select-text-add').click(function() {
            var number = parseInt($(this).attr('data-add_number'));
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            for (var i = 0; i < number; i++) {
                var new_input = $('#' + id + ' li').last().clone();

                new_input.find('input[type="text"]').val('');
                new_input.find('.select2-container').remove();
                new_input.find('select').css('width', 340 + "px").prop('selectedIndex', 0).select2(default_params);

                $('#' + id).append(new_input);
            }
        });
    };

    function addIconToSelect(icon) {
        if (icon.hasOwnProperty('id')) {
            return "<span><i class='" + icon.id + "'></i>" + "&nbsp;&nbsp;" + icon.id.toUpperCase() + "</span>";
        }
    }
})(jQuery);