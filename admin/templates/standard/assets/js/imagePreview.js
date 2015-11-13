/*
 * Image preview script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */

this.imagePreview = function(attr) {
    /* CONFIG */    
    xOffset = -20;
    yOffset = 15;
    attr_data = attr;

    // these 2 variable determine popup's distance from the cursor
    // you might want to adjust to get the right result

    /* END CONFIG */
    $(".gallery-preview").hover(function(e) {
        this.t = this.title;
        this.title = "";
        var c = (this.t != "") ? "<br/>" + this.t : "";
        chd = $(window).height() - (e.pageY - $(window).scrollTop());
        xOffset = -20;
        if (chd < 385)
            xOffset = 385;
        img_top = e.pageY - xOffset;
        img_left = e.pageX + yOffset;

        $("body").append("<p id='gallery-preview'><img style='max-height: 350px;' src='" + this[attr_data] + "' alt='" + c + "' />" + c + "</p>");
        $("#gallery-preview").css({"top": img_top + "px", "left": img_left + "px"}).fadeIn("fast");
    },
            function() {
                this.title = this.t;
                $("#gallery-preview").remove();
            });

    $(".gallery-preview").mousemove(function(e) {
        chd = $(window).height() - (e.pageY - $(window).scrollTop());
        xOffset = -20;
        if (chd < 385)
            xOffset = 385;

        img_top = e.pageY - xOffset;
        img_left = e.pageX + yOffset;        
        $("#gallery-preview").css({top: img_top + "px", left: img_left + "px"});
    });
};


// starting the script on page load
$(document).ready(function() {
    imagePreview("rel");
});
