/**
 * Agora Broadcast Client
 */
var peers_network = [];
var left_network = [];
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
    subscribe(streamId);
    // Subscribe to the stream.
    client.subscribe(stream, function(err) {
        console.log("[ERROR] : subscribe stream failed", err);
    });
    initializeUi();
});

client.on("stream-removed", function(evt) {
    var stream = evt.stream;
    var streamId = stream.getId();
    stream.stop(); // stop the stream
    stream.close(); // clean up and close the camera stream
    console.log("Remote stream is removed " + stream.getId());
    initializeUi();
});
function subscribe(sid)
{
    client.on("stream-subscribed", function(evt) {
        var remoteStream = evt.stream;
        var rid = remoteStream.getId();
        if($("#stream-player-"+ rid).length == 0){
            $('#full-screen-video').append('<div class="stream-player grid-player" id="stream-player-'+rid+'" style="grid-area: auto"> <div class="stream-uid">UID: '+rid+'</div><span class="full-vid" value="'+rid+'"><i class="fas fa-expand"></i></span></div>');
        }
        remoteStream.play("stream-player-"+rid+"");
        //remoteStream.play("full-screen-video");
        console.log(
            "Successfully subscribed to remote stream: " + remoteStream.getId()
        );
        initializeUi();
    });
}

// peer online status
client.on("peer-online", function(evt) {
    console.log(evt.uid+" peer online");
    if($('#full-screen-video > h3').length != 0) {
        $('#full-screen-video > h3').remove();
    }
    initializeUi();
});

// remove the remote-container when a user leaves the channel
client.on("peer-leave", function(evt) {
    console.log(evt.uid);
     $('#stream-player-'+evt.uid+'').remove();
    console.log("Remote stream has left the channel: " + evt.uid);
    console.log('peer leave');
    if($('#full-screen-video > h3').length == 0 && $('#full-screen-video > div > div > video').length == 0) {
        $('#full-screen-video').append('<h3 style="color: #fff;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);">Your Speaker left or ended this Session</h3>');
    }
    initializeUi();
    evt.stream.stop(); // stop the stream
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
    $('#stream-player-'+remoteId).css('display','none');
    initializeUi();
});

client.on("unmute-video", function(evt) {
    var remoteId = evt.uid;
    $('#stream-player-'+remoteId).css('display','block');
    initializeUi();
});

// ingested live stream
client.on("streamInjectedStatus", function(evt) {
    console.log("Injected Steram Status Updated");
    console.log('stream inject');
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
        null,
        function(uid) {
            console.log("User " + uid + " join channel successfully");
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

function initializeUi() {
    $('#full-screen-video > div').removeClass('hidden');
    var window_width = window.outerWidth;
    if(window.innerHeight < $('#full-screen-video').height()){
        $('body').css('overflow-y','scroll');
    }
    if(window_width < 500) {
        var childrens = $('#full-screen-video > div').length;
        $('#full-screen-video').attr('class','elem' + childrens);
        if (childrens > 3) {
            if(!$('#full-screen-video').hasClass('multiple')) {
                $('#full-screen-video').addClass('multiple');
            }
        }
    } else {
        var childrens = $('#full-screen-video > div').length;
        $('#full-screen-video').attr('class','sp' + childrens);
        if (childrens > 5) {
            if(!$('#full-screen-video').hasClass('spmultiple')) {
                $('#full-screen-video').addClass('spmultiple');
            }
        }
    }
}

$(document).on('click', '.full-vid' ,function ()
{
    var fid = $(this).attr('value');
    if(!$(this).parentsUntil('#full-screen-video').parent().children('div').hasClass('hidden')) {
        $('#full-screen-video > div').addClass('hidden');
        $(this).parent('div').removeClass('hidden');
        $(this).children('i').removeClass('fa-expand');
        $(this).children('i').addClass('fa-compress');
        $(this).parentsUntil('#full-screen-video').parent().addClass('expanded');
    } else {
        $('#full-screen-video > div').removeClass('hidden');
        $(this).children('i').addClass('fa-expand');
        $(this).children('i').removeClass('fa-compress');
        $(this).parentsUntil('#full-screen-video').parent().removeClass('expanded');
    }
    f_elem = "stream-player-"+fid;
    console.log(f_elem);
})