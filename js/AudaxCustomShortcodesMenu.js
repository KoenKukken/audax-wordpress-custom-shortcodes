window.onload = function () {
    if (typeof jQuery == "undefined") {
        var jq = document.createElement('script');
        jq.type = 'text/javascript';
        jq.src = '/wp-content/plugins/AudaxCustomShortcodes/js/jquery-2.1.1.min.js';
        document.getElementsByTagName('head')[0].appendChild(jq);
    }
};
jQuery(document).ready(function () {
    jQuery('body').on('click', 'table.audax-custom-shortcodes-table .audax-input-show', function () {
        jQuery(this).hide();
        jQuery(this).parent().children('.audax-input-hidden').show();
    });
    jQuery('body').on('click', 'button.audax-custom-shortcodes-new', function () {
        var lastTr = jQuery('body table.audax-custom-shortcodes-table tr:last input').attr('name');
        if (lastTr.indexOf('-new-') > -1) {
            var countArray = lastTr.split('[');
            var count = countArray[1].replace(']', '');
            count++;
        } else {
            count = 0;
        }
        console.log(count);
        jQuery('table.audax-custom-shortcodes-table').append('<tr>'
                + '<td><input type="text" name="audax-custom-shortcodes-new-collection[' + count + ']" maxlength="255"/></td>'
                + '<td><input type="text" name="audax-custom-shortcodes-new-tag[' + count + ']" maxlength="255"/></td>'
                + '<td><input type="text" name="audax-custom-shortcodes-new-value[' + count + ']" maxlength="255"/></td>'
                + '<td></td></tr>');
    });
});