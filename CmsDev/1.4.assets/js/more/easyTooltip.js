(function($) {
    $.fn.sktToolTip = function(options) {
        var defaults = {xOffset: 20, yOffset: 0, tooltipId: "sktToolTip", clickRemove: false, content: "", useElement: ""};
        var options = $.extend(defaults, options);
        var content;
        this.each(function() {
            var title = $(this).attr("title");
            $(this).hover(function(e) {
                content = (options.content != "") ? options.content : title;
                content = (options.useElement != "") ? $("#" + options.useElement).html() : content;
                $(this).attr("title", "");
                if (content != "" && content != undefined) {
                    $("body").append("<div id='" + options.tooltipId + "'>" + content + "</div>");
                    $("#" + options.tooltipId).css("position", "absolute").css("top", (e.pageY - options.yOffset) + "px").css("left", (e.pageX + options.xOffset) + "px").css("display", "none").fadeIn("fast")
                }
            }, function() {
                $("#" + options.tooltipId).remove();
                $(this).attr("title", title)
            });
            $(this).mousemove(function(e) {
                $("#" + options.tooltipId).css("top", (e.pageY - options.yOffset) + "px").css("left", (e.pageX + options.xOffset) + "px")
            });
            if (options.clickRemove) {
                $(this).mousedown(function(e) {
                    $("#" + options.tooltipId).remove();
                    $(this).attr("title", title)
                })
            }
        })
    }
})(jQuery);