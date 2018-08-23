jQuery(document).ready(function(e) {
    e("#vegas_image_button").click(function(t) {
        t.preventDefault();
        frame = wp.media({
            title: "Vegas Slider",
            frame: "post",
            multiple: true,
            library: {
                type: "image"
            },
            button: {
                text: "Add Image"
            }
        });
        frame.on("close", function(t) {
            var n = [];
            images = frame.state().get("selection");
            images.each(function(e) {
                n.push(e.attributes.url);
            });
            var r = [];
            IDs = frame.state().get("selection");
            IDs.each(function(e) {
                r.push(e.attributes.id);
            });
            var s = "";
            for (var o = 0; o < n.length; o++) {
                s += '<div id="' + r[o] + '" class="thumbnail"><img id="' + r[o] + '"src="' + n[o] + '"><span id="' + r[o] + '" class="vegas_remove">&times;</span></div>';
            }
            e("#thumbnails").append(s);
            e(".vegas_remove").last().on('click', function() {
                e("#" + e(this).attr("id")).hide().remove();
            });
        });
        frame.open();
    });
});