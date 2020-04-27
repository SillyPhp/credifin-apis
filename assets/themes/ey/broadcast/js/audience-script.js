/**
 * Agora Broadcast Client
 */

var agoraAppId = app_id; // set app id
var channelName = channel_name; // set channel name

// create client
var client = AgoraRTC.createClient({ mode: "live", codec: "vp8" }); // vp8 to work across mobile devices

// set log level:
// -- .DEBUG for dev
// -- .NONE for prod
AgoraRTC.Logger.setLogLevel(AgoraRTC.Logger.NONE);
$(document).ready(function() {
    // Due to broswer restrictions on auto-playing video,
    // user must click to init and join channel
    $("#watch-live-btn").click(function() {
        console.log("user clicked to watch broadcast");
        // init Agora SDK
        client.init(
            agoraAppId,
            function() {
                $("#watch-live-overlay").remove();
                console.log("AgoraRTC client initialized");
                joinChannel(); // join channel upon successfull init
            },
            function(err) {
                console.log("[ERROR] : AgoraRTC client init failed", err);
            }
        );
    });
});

client.on("stream-published", function(evt) {
    console.log("Publish local stream successfully");
});

// connect remote streams
client.on("stream-added", function(evt) {
    var stream = evt.stream;
    var streamId = stream.getId();
    console.log("New stream added: " + streamId);
    console.log("Subscribing to remote stream:" + streamId);
    // Subscribe to the stream.
    client.subscribe(stream, function(err) {
        console.log("[ERROR] : subscribe stream failed", err);
    });
});

client.on("stream-removed", function(evt) {
    var stream = evt.stream;
    stream.stop(); // stop the stream
    stream.close(); // clean up and close the camera stream
    console.log("Remote stream is removed " + stream.getId());
});

client.on("stream-subscribed", function(evt) {
    var remoteStream = evt.stream;
    remoteStream.play("full-screen-video");
    console.log(
        "Successfully subscribed to remote stream: " + remoteStream.getId()
    );
    if($('#full-screen-video > h3').length != 0) {
        $('#full-screen-video > h3').remove();
    }
});

// remove the remote-container when a user leaves the channel
client.on("peer-leave", function(evt) {
    console.log("Remote stream has left the channel: " + evt.uid);
    evt.stream.stop(); // stop the stream
    if($('#full-screen-video > h3').length == 0) {
        $('#full-screen-video').append('<h3 style="color: #fff;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);">Your Teacher left or ended this class</h3>');
    }
});

// show mute icon whenever a remote has muted their mic
client.on("mute-audio", function(evt) {
    var remoteId = evt.uid;
});

client.on("unmute-audio", function(evt) {
    var remoteId = evt.uid;
});

// show user icon whenever a remote has disabled their video
client.on("mute-video", function(evt) {
    var remoteId = evt.uid;
});

client.on("unmute-video", function(evt) {
    var remoteId = evt.uid;
});

// ingested live stream
client.on("streamInjectedStatus", function(evt) {
    console.log("Injected Steram Status Updated");
    // evt.stream.play('full-screen-video');
    console.log(JSON.stringify(evt));
});

// join a channel
function joinChannel() {
    //var token = generateToken();
    var token = access_token;

    // set the role
    client.setClientRole(
        "audience",
        function() {
            console.log("Client role set to audience");
        },
        function(e) {
            console.log("setClientRole failed", e);
        }
    );

    client.join(
        token,
        channelName,
        0,
        function(uid) {
            console.log("User " + uid + " join channel successfully");
            if($('#full-screen-video > h3').length == 0) {
                $('#full-screen-video').append('<h3 style="color: #fff;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);">Your teacher is connecting. Please wait..</h3>');
            }
        },
        function(err) {
            console.log("[ERROR] : join channel failed", err);
        }
    );
}

function leaveChannel() {
    client.leave(
        function() {
            console.log("client leaves channel");
        },
        function(err) {
            console.log("client leave failed ", err); //error handling
        }
    );
}

// use tokens for added security
function generateToken() {
    // make a restful call to token server
    return null; // TODO: add a token generation
}