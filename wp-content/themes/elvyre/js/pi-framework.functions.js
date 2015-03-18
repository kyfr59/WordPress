/*
 * PIXEL INDUSTRY FUNCTIONS FILE
 * 
 * Includes functions necessary for proper theme work and some helper functions.
 * 
 */

var PiFrameworkFunctions = {
    /*
     * Helper functions for creating cookies
     * 
     * @param {string} name
     * @param {string} value
     * @param {int} days
     * @returns {void}
     */

    createCookie: function(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    },
    /*
     * Helper functions for reading cookies
     * 
     * @param {string} name 
     * @returns {null}
     */
    readCookie: function(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length, c.length);
            }
        }
        return null;
    },
    /*
     * 
     * @param {string} name
     * @returns {void}
     */
    eraseCookie: function(name) {
        this.createCookie(name, "", -1);
    },
    /*
     * Check if current device is touch device.
     * !IMPORTANT: Not working on IE11
     * 
     * @returns {boolean} 
     */
    is_touch_device: function() {
        // first part for most browsers, second for ie10
        return !!('ontouchstart' in window) || !!(window.navigator.msMaxTouchPoints);
    }


}