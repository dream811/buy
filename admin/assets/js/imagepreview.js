! function(a) {
    "use strict";
    a.fn.anarchytip = function(b) {
        var c = a.extend({
            xOffset: 10,
            yOffset: 30
        }, b);
        return this.each(function() {
            var b = a(this);
            b.hover(function(b) {
                this.t = this.title, this.title = "";
                var d = "" != this.t ? "<br/>" + this.t : "";
                a("body").append("<p id='preview'><img width='400' src='" + this.href + "' alt='Image preview' />" + d + "</p>"), a("#preview").css({
                    top: b.pageY - c.xOffset + "px",
                    left: b.pageX + c.yOffset + "px"
                }).fadeIn()
            }, function() {
                this.title = this.t, a("#preview").remove()
            }), b.mousemove(function(b) {
                a("#preview").css("top", b.pageY - c.xOffset + "px").css("left", b.pageX + c.yOffset + "px")
            })
        })
    }
}(jQuery);