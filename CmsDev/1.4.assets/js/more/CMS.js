var CMS = function () {
    return{ImageSRC: function (el, URL, W, H, C) {
            if (URL !== "") {
                URL = "dummy.png"
            }
            if (W !== "") {
                W = "-" + W
            }
            if (H !== "") {
                H = "x" + H
            }
            if (C !== "") {
                C = "-" + C
            }
            var I = urlencode(base64_encode(utf8_encode(URL)));
            Image = I.replace("%3D", "");
            el = $(el);
            el.attr("src", "/_FileSystems/_thumb_/?/" + Image + W + H + C)
        }}
}();