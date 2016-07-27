$(document).ready(function() {
    /**
     * Adds and removes classes to divs when scrolling
     * @return {void}
     */
    function scroll() {
        var scrollUpButton = document.getElementById('scrollup');
        if ($(window).scrollTop() >= 500) {
            scrollUpButton.style.display = 'inline-block';
        } else {
            scrollUpButton.style.display = 'none';
        }
    }
    // calling the function on scroll
    document.onscroll = scroll;
});