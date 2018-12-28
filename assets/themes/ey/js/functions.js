function ajax(method, url, data = null) {
    return $.ajax({
        method: method,
        url: url,
        async: false,
        dataType: "json",
//        contentType: content,
        data: data,
//        cache: true,
//        beforeSend: before,
//        complete: after
    });
}

ajax().done(function (result) {
    return result;
});

var utilities = {
    initials: function(){
        var canvas = document.getElementsByClassName("user-icon");
        for (var i = 0; i < canvas.length; i++) {
            var context = canvas[i].getContext("2d");
            var colours = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];
            var name = canvas[i].getAttribute("name");
            nameSplit = name.split(" "),
                initials = '';
            for (var j = 0; j < nameSplit.length && j < 2; j++) {
                initials += nameSplit[j].charAt(0).toUpperCase();
            }
            var canvasWidth = canvas[i].getAttribute("width"),
                canvasHeight = canvas[i].getAttribute("height");
            canvasCssWidth = canvasWidth,
                canvasCssHeight = canvasHeight;

            if (!window.devicePixelRatio) {
                canvas[i].setAttribute("width", canvasWidth * window.devicePixelRatio);
                canvas[i].setAttribute("height", canvasHeight * window.devicePixelRatio);
                canvas[i].style.width = canvasCssWidth;
                canvas[i].style.height = canvasCssHeight;
                context.scale(window.devicePixelRatio, window.devicePixelRatio);
            }

            if(canvas[i].getAttribute("color") != "") {
                context.fillStyle = canvas[i].getAttribute("color");
            } else {
                context.fillStyle = colours[Math.floor(Math.random() * colours.length)];
            }

            context.fillRect(0, 0, canvas[i].width, canvas[i].height);
            context.font = canvas[i].getAttribute("font") + " Arial";
            context.textAlign = "center";
            context.fillStyle = "#fff";
            context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.5);
        }
    }
}

utilities.initials();