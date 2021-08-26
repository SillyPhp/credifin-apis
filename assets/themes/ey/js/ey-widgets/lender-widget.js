(function() {
    var script, iframe;
    var isExpandedFrame = false;
    var onLoadCounter = 0;
// set iframe height
    var setHeight = function(data) {
        var height;
        try {
            height = parseInt(data.height);
        } catch(e) {
// Ignore errors
            return;
        }
        iframe.setAttribute("height", height + "px");
    };
// set iframe scroll position
    var setScroll = function() {
        var top = iframe.getBoundingClientRect().top + window.pageYOffset;
        window.scrollTo(0, top);
    };
    var onMessage = function(e) {
        var data;
        if (e.origin === "https://www.empoweryouth.com") {
// handle errors from parsing data
            try {
                data = JSON.parse(e.data);
            } catch (e) {
                data = {}
            }
            var frameUrl = "/framed-widgets/lender";
// for other frames that are posting messages that aren't us and use
// the path to only adjust messages received for a specific iframe
            if (!isExpandedFrame && (!("muse" in data) || data.path.indexOf(frameUrl) === -1)) {
                return;
            }
            if (data.path.indexOf(frameUrl) > -1 || isExpandedFrame) {
                if (data.action === "set-height") {
                    setHeight(data);
                } else if (data.action === "set-scroll") {
                    setScroll(data);
                }
            }
        }
    };
    function addQueryParam(url, key, value) {
        var parser = document.createElement("a");
        parser.href = url;
        var hasQueryString = !!parser.search.split("?")[1];
        if (hasQueryString) {
            parser.search += "&" + key + "=" + value;
        } else {
            parser.search += "?" + key + "=" + value;
        }
        return parser.href;
    }
// try and find the script based on the src. use raw because sometimes a
// script can have query parameters and need to get those query params -
// not using raw would evaluate an `&` to a `&amp;`
    script = document.querySelector("script[src$='/assets/themes/ey/js/ey-widgets/lender-widget.js']");
    var src = "https://www.empoweryouth.com/framed-widgets/lender"
    var title = null;
    // src = addQueryParam(src, "parent_page_referrer", encodeURIComponent(document.referrer));
    iframe = document.createElement("iframe");
    iframe.setAttribute("frameborder", "0");
    iframe.setAttribute("allowfullscreen", "true");
    iframe.setAttribute("scrolling", "yes");
    // iframe.setAttribute("src", src);
    iframe.setAttribute("width", "100%");
    //iframe.setAttribute("height", "100vh");
    iframe.style.height = "100vh";
    iframe.setAttribute("id", "idIframe");
    iframe.style.width = "10px";
    iframe.style.minWidth = "100%";
    if (title) {
        iframe.title = title;
    }
    window.addEventListener('load', function(e) {
        var elem = document.getElementById("ey-lender-loan");
        var col_id = elem.getAttribute("data-id");
        //script.parentNode.insertBefore(iframe, script.nextSibling);
        iframe.setAttribute("src", src+"/"+col_id);
        elem.appendChild(iframe);
    });
    if (window.addEventListener) {
        window.addEventListener("message", onMessage, false);
    } else if (window.attachEvent) {
        window.attachEvent("onmessage", onMessage, false);
    }
// Viewport helpers for iFrame
    var isIos = function() {
        return ["iPad", "iPhone", "iPod"].indexOf(window.navigator.platform) !== -1;
    };
    /**
     * Sends viewport data as a postMessage to the iFrame for viewport tracking.
     * Calls from the iFrame will give incorrect sizes.
     */
    var updateViewportMessage = function(e) {
        var type = "muse-" + e.type;
        var viewport = {
            top: -iframe.getBoundingClientRect().top,
            height: isIos() ? document.documentElement.clientHeight : window.innerHeight,
            left: window.pageXOffset,
            width: isIos() ? document.documentElement.clientWidth : window.innerWidth
        };
        iframe.contentWindow.postMessage({"type": type, "viewport": viewport}, "*");
    }
    iframe.onload = function(e) {
        updateViewportMessage(e);
// We do not want to scroll to top on the initial onload event
        if (onLoadCounter > 0) {
            window.scrollTo(0, iframe.offsetTop - 100);
        }
        onLoadCounter = onLoadCounter + 1;
    };
    var timer = null;
    var scrollEvent = function(e) {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(function() {
            updateViewportMessage(e);
        }, 500);
    }
    window.addEventListener("resize", scrollEvent);
    window.addEventListener("scroll", scrollEvent);
})();