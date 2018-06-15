jQuery(document).ready(function(){
    jQuery('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
            || location.hostname == this.hostname) {
    
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
               if (target.length) {
                 jQuery('html,body').animate({
                     scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
    // Try to cut down on spam.
    jQuery("#footer-contact-email").attr('href', 'mailto:hello@howtobuildwithwp.com');
});