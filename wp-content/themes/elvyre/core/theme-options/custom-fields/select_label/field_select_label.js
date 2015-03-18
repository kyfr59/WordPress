/* global redux_change */
(function($) {
    "use strict";

    $.redux = $.redux || {};

    $(document).ready(function() {
        //menu manager functionality
        $.redux.select_label();
    });

    $.redux.select_label = function() {

        $('select.select-label-select').each(function() {

            var default_params = {
                width: 'resolve',
                triggerChange: true,
                allowClear: true,
                placeholder: "Please select icon"
            };

            default_params = $.extend({}, {formatResult: addIconToSelect, formatSelection: addIconToSelect, escapeMarkup: function(m) {
                    return m;
                }}, default_params);

            $(this).select2(default_params);

            $(this).on('change', function(e) {
                $(this).closest('li').find('.value-store').val($(this).val());
            });
        });

    };

    function addIconToSelect(icon) {
        if (icon.hasOwnProperty('id')) {
            return "<span><i class='" + icon.id + "'></i>" + "&nbsp;&nbsp;" + icon.id.toUpperCase() + "</span>";
        }
    }
})(jQuery);