<script type="text/javascript">
    (function($) {

        $.cleditor.buttons.Layout2 = {
            css: {
                backgroundImage: "URL(" + SKTURL_TemplateSite + "/SKT_Editor_Parts/LayoutBox.gif)",
                backgroundPosition: "0 0",
                width: "235px"
            },
            name: "Layout2",
            title: "Layout2",
            command: "inserthtml",
            popupName: "Layout2",
            popupHover: true,
            buttonClick: function(e, data) {
                $(data.popup).width(255);
            },
            popupClick: function(e, data) {
                var index = parseInt(e.target.style.zIndex);
                var C = $("#sktLayoutsObj .bloque:eq(" + index + ")").html();
                $.cleditor.disable;
                data.value = C;
            }
        };
        $.cleditor.buttons.Layout2.popupContent = $('#sktPNGLayoutObj').html();
        $.cleditor.defaultOptions.controls = $.cleditor.defaultOptions.controls.replace("Layout2", "Layout2");

    })(jQuery);
</script>