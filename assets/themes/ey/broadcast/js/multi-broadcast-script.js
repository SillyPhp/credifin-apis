/**
 * Agora Broadcast Client
 */
var agoraAppId = app_id; // set app id
var channelName = channel_name; // set channel name
$('#session_expired').html('<h3>Connecting..!!</h3>');
$('#session_expired').css('display','block');
// create client instance
var client = AgoraRTC.createClient({ mode: "live", codec: "vp8" }); // h264 better detail at a higher motion
var screenClient = AgoraRTC.createClient({mode: 'rtc', codec: 'vp8'});
var mainStreamId; // reference to main stream
// set video profile
// [full list: https://docs.agora.io/en/Interactive%20Broadcast/videoProfile_web?platform=Web#video-profile-table]
var cameraVideoProfile = "720_2"; // 960 × 720 @ 30fps  & 750kbs
var sharingProfileRes = "720p_1";

// keep track of streams
var localStreams = {
    uid: "",
    camera: {
        camId: "",
        micId: "",
        stream: {}
    }
};

var sharingStreams = {
    uid: "",
    camera: {
        camId: "",
        micId: "",
        stream: {}
    }
};
// keep track of devices
var devices = {
    cameras: [],
    mics: []
};

var externalBroadcastUrl = "";

// default config for rtmp
var defaultConfigRTMP = {
    width: 640,
    height: 360,
    videoBitrate: 400,
    videoFramerate: 15,
    lowLatency: false,
    audioSampleRate: 48000,
    audioBitrate: 48,
    audioChannels: 1,
    videoGop: 30,
    videoCodecProfile: 100,
    userCount: 0,
    userConfigExtraInfo: {},
    backgroundColor: 0x000000,
    transcodingUsers: []
};

// set log level:
// -- .DEBUG for dev
// -- .NONE for prod
AgoraRTC.Logger.setLogLevel(AgoraRTC.Logger.NONE);

// init Agora SDK
    client.init(
        agoraAppId,
        function () {
            console.log("AgoraRTC client initialized");
            joinChannel(); // join channel upon successfull init
        },
        function (err) {
            console.log("[ERROR] : AgoraRTC client init failed", err);
        }
    );
//set source host
// client callbacks
client.on("stream-published", function(evt) {
    $('#session_expired').css('display','none');
    console.log("Publish local stream successfully");
    initializeUi();
});
// when a remote stream is added
client.on("stream-added", function(evt) {
    var remoteStream = evt.stream;
    // client.setRemoteVideoStreamType(remoteStream, 1);
    // client.setLowStreamParameter({
    //     width: 120,
    //     height: 120,
    //     framerate: 15,
    //     bitrate: 120,
    // });
    var id = remoteStream.getId();
    if (id !== uid) {
        client.subscribe(remoteStream, function (err) {
            console.log("stream subscribe failed", err);
        })
    }
     console.log('stream-added remote-uid: ', id);
});
client.on("stream-subscribed", function (evt) {
    var remoteStream = evt.stream;
    var id = remoteStream.getId();
    // Play the remote stream.
    if($("#stream-player-"+ id).length == 0){
        $('#full-screen-video').append('<div class="stream-player grid-player" id="stream-player-'+id+'" style="grid-area: auto"> <div class="stream-uid">UID: '+id+'</div><span class="full-vid" value="'+id+'"><i class="fas fa-expand"></i></span></div>');
    }
    remoteStream.play("stream-player-"+id+"");
    console.log('stream-subscribed remote-uid: ', id);
    initializeUi();
})
client.on("stream-removed", function(evt) {
    var stream = evt.stream;
    var id = stream.getId();
    stream.stop(); // stop the stream
    stream.close(); // clean up and close the camera stream
    console.log("Remote stream is removed " + stream.getId());
});

//live transcoding events..
client.on("liveStreamingStarted", function(evt) {
    // console.log("Live streaming started");
});

client.on("liveStreamingFailed", function(evt) {
    // console.log("Live streaming failed");
});

client.on("liveStreamingStopped", function(evt) {
    // console.log("Live streaming stopped");
});

client.on("liveTranscodingUpdated", function(evt) {
    // console.log("Live streaming updated");
});

// ingested live stream
client.on("streamInjectedStatus", function(evt) {
    // console.log("Injected Steram Status Updated");
    // console.log(JSON.stringify(evt));
});

// when a remote stream leaves the channel
client.on("peer-leave", function(evt) {
    $('#stream-player-'+evt.stream.getId()+'').remove();
    $('#stream-player-'+sharingStreams.uid+'').remove();
    // console.log("Remote stream has left the channel: " + evt.stream.getId());
    initializeUi();
});

// show mute icon whenever a remote has muted their mic
client.on("mute-audio", function(evt) {
    // console.log("Mute Audio for: " + evt.uid);
});

client.on("unmute-audio", function(evt) {
    // console.log("Unmute Audio for: " + evt.uid);
});

// show user icon whenever a remote has disabled their video
client.on("mute-video", function(evt) {
    // console.log("Mute Video for: " + evt.uid);
});

client.on("unmute-video", function(evt) {
    // console.log("Unmute Video for: " + evt.uid);
});

// join a channel
function joinChannel() {
    //var token = generateToken();
    var token = access_token;
    var userID = uid; // set to null to auto generate uid on successfull connection

    // set the role
    client.setClientRole(
        "host",
        function() {
            console.log("Client role set as host.");
        },
        function(e) {
            console.log("setClientRole failed", e);
        }
    );

    // client.join(token, 'allThingsRTCLiveStream', 0, function(uid) {
    client.join(
        token,
        channelName,
        userID,
        function(uid) {
            createCameraStream(uid, {});
            localStreams.uid = uid; // keep track of the stream uid
            console.log("User " + uid + " joined channel successfully");
        },
        function(err) {
            //alert("[ERROR] : Broadcast Session Expired !!", err);
            $('#session_expired').html('<h3>Broadcast Session Expired</h3>');
            console.log("[ERROR] : join channel failed", err);
        }
    );
    // client.enableDualStream(function() {
    //     console.log("Enable dual stream success!")
    // }, function(err) {
    //     console.log(err)
    // })
}

// video streams for channel
function createCameraStream(uid, deviceIds) {
    // console.log("Creating stream with sources: " + JSON.stringify(deviceIds));

    var localStream = AgoraRTC.createStream({
        streamID: uid,
        audio: true,
        video: true,
        screen: false,
    });
    localStream.setVideoProfile(cameraVideoProfile);
    // The user has granted access to the camera and mic.
    localStream.on("accessAllowed", function() {
        if (devices.cameras.length === 0 && devices.mics.length === 0) {
            console.log("[DEBUG] : checking for cameras & mics");
            getCameraDevices();
            getMicDevices();
        }
        console.log("accessAllowed");
    });
    // The user has denied access to the camera and mic.
    localStream.on("accessDenied", function() {
        console.log("accessDenied");
    });

    localStream.init(
        function() {
            console.log("getUserMedia successfully");
            $('#full-screen-video').append('<div class="stream-player grid-player main-stream-player " id="stream-player-'+uid+'"> <div class="stream-uid">UID: '+uid+'</div><span class="full-vid" value="'+uid+'"><i class="fas fa-expand"></i></span></div>');
            localStream.play("stream-player-"+uid+""); // play the local stream on the main div
             // play the local stream on the main div
            // publish local stream

            if ($.isEmptyObject(localStreams.camera.stream)) {
                enableUiControls(localStream); // move after testing
            } else {
                //reset controls
                $("#mic-btn").prop("disabled", false);
                $("#video-btn").prop("disabled", false);
                $("#exit-btn").prop("disabled", false);
                $("#share-sreen-btn").prop("disabled", false);
            }

            client.publish(localStream, function(err) {
                console.log("[ERROR] : publish local stream error: " + err);
            });
            localStreams.camera.stream = localStream; // keep track of the camera stream for later
        },
        function(err) {
            console.log("[ERROR] : getUserMedia failed", err);
        }
    );
}

function createSharingScreen()
{
    console.log('enabling sharing');
    sharingStreams.uid = uid+"1";
    var screenStream = AgoraRTC.createStream({
        streamID: sharingStreams.uid,
        audio: false,
        video: false,
        screen: true,
    });
    screenStream.setScreenProfile(sharingProfileRes);
    screenStream.init(function (){
        // Play the sharing stream.
        $('#sharing_mode').addClass('new_sharing');
        $('#stream-player-'+localStreams.uid+'').addClass('adjust_sharing');
        if($("#stream-player-"+ sharingStreams.uid).length == 0){
            $('#full-screen-video').append('<div class="stream-player grid-player" id="stream-player-'+sharingStreams.uid+'" style="grid-area: auto"> <div class="stream-uid">UID: '+sharingStreams.uid+'</div></div>');
        }
        screenStream.play("stream-player-"+sharingStreams.uid+"");
        // Publish thesharing stream.
        screenClient.publish(screenStream, function(err) {
            console.log("[ERROR] : publish local sharing error: " + err);
        });
    },function (err)
    {
        console.log(err);
    });
}

function joinSharing()
{
    console.log('staring sharing');
    var token = access_token;
    var userID = null; // set to null to auto generate uid on successfull connection

    screenClient.join(
        token,
        channelName,
        userID,
        function(uid) {
            createSharingScreen(uid);
            console.log("User " + uid + " joined channel successfully");
        },
        function(err) {
            console.log("[ERROR] : sharing failed", err);
        }
    );
}

function leaveChannel() {
    client.leave(
        function() {
            console.log("client leaves channel");
            localStreams.camera.stream.stop(); // stop the camera stream playback
            localStreams.camera.stream.close(); // clean up and close the camera stream
            client.unpublish(localStreams.camera.stream); // unpublish the camera stream
            //disable the UI elements
            leaving_disable_controls();
        },
        function(err) {
            console.log("client leave failed ", err); //error handling
        }
    );
}

function leaving_disable_controls()
{
    $('#stream-player-'+localStreams.uid+'').remove();
    $("#mic-btn").attr("id", "m");
    $("#video-btn").attr("id", "v");
    $("#exit-btn").attr("id", "e");
    $("#share-sreen-btn").attr("id", "s");
    $('#session_expired').html('<h3>You Ended This Session</h3>');
    $('#session_expired').css('display','block');
}

function leaveSharing()
{
    $('#stream-player-'+sharingStreams.uid+'').remove();
    screenClient.leave(
        function() {
            console.log("client leaves channel");
        },
        function(err) {
            console.log("client leave failed ", err); //error handling
        }
    );
    $('#stream-player-'+localStreams.uid+'').removeClass('adjust_sharing');
    //$('#sharing_mode').css('display','none');
    $('#sharing_mode').removeClass('new_sharing');
}

// use tokens for added security
function generateToken() {
    return null; // TODO: add a token generation
}

function changeStreamSource(deviceIndex, deviceType) {
    console.log("Switching stream sources for: " + deviceType);
    var deviceId;
    var existingStream = false;

    if (deviceType === "video") {
        deviceId = devices.cameras[deviceIndex].deviceId;
    }

    if (deviceType === "audio") {
        deviceId = devices.mics[deviceIndex].deviceId;
    }

    localStreams.camera.stream.switchDevice(
        deviceType,
        deviceId,
        function() {
            console.log(
                "successfully switched to new device with id: " +
                JSON.stringify(deviceId)
            );
            // set the active device ids
            if (deviceType === "audio") {
                localStreams.camera.micId = deviceId;
            } else if (deviceType === "video") {
                localStreams.camera.camId = deviceId;
            } else {
                console.log("unable to determine deviceType: " + deviceType);
            }
        },
        function() {
            console.log(
                "failed to switch to new device with id: " + JSON.stringify(deviceId)
            );
        }
    );
}

// helper methods
function getCameraDevices() {
    console.log("Checking for Camera Devices.....");
    client.getCameras(function(cameras) {
        devices.cameras = cameras; // store cameras array
        cameras.forEach(function(camera, i) {
            var name = camera.label.split("(")[0];
            var optionId = "camera_" + i;
            var deviceId = camera.deviceId;
            if (i === 0 && localStreams.camera.camId === "") {
                localStreams.camera.camId = deviceId;
            }
            $("#camera-list").append(
                '<a class="dropdown-item" id="' + optionId + '">' + name + "</a>"
            );
        });
        $("#camera-list a").click(function(event) {
            var index = event.target.id.split("_")[1];
            changeStreamSource(index, "video");
        });
    });
}

function getMicDevices() {
    console.log("Checking for Mic Devices.....");
    client.getRecordingDevices(function(mics) {
        devices.mics = mics; // store mics array
        mics.forEach(function(mic, i) {
            var name = mic.label.split("(")[0];
            var optionId = "mic_" + i;
            var deviceId = mic.deviceId;
            if (i === 0 && localStreams.camera.micId === "") {
                localStreams.camera.micId = deviceId;
            }
            if (name.split("Default - ")[1] != undefined) {
                name = "[Default Device]"; // rename the default mic - only appears on Chrome & Opera
            }
            $("#mic-list").append(
                '<a class="dropdown-item" id="' + optionId + '">' + name + "</a>"
            );
        });
        $("#mic-list a").click(function(event) {
            var index = event.target.id.split("_")[1];
            changeStreamSource(index, "audio");
        });
    });
}

function startLiveTranscoding() {
    console.log("start live transcoding");
    var rtmpUrl = $("#rtmp-url").val();
    var width = parseInt($("#window-scale-width").val(), 10);
    var height = parseInt($("#window-scale-height").val(), 10);

    var configRtmp = {
        width: width,
        height: height,
        videoBitrate: parseInt($("#video-bitrate").val(), 10),
        videoFramerate: parseInt($("#framerate").val(), 10),
        lowLatency: $("#low-latancy").val() === "true",
        audioSampleRate: parseInt($("#audio-sample-rate").val(), 10),
        audioBitrate: parseInt($("#audio-bitrate").val(), 10),
        audioChannels: parseInt($("#audio-channels").val(), 10),
        videoGop: parseInt($("#video-gop").val(), 10),
        videoCodecProfile: parseInt($("#video-codec-profile").val(), 10),
        userCount: 1,
        userConfigExtraInfo: {},
        backgroundColor: parseInt($("#background-color-picker").val(), 16),
        transcodingUsers: [
            {
                uid: localStreams.uid,
                alpha: 1,
                width: width,
                height: height,
                x: 0,
                y: 0,
                zOrder: 0
            }
        ]
    };

    // set live transcoding config
    client.setLiveTranscoding(configRtmp);
    if (rtmpUrl !== "") {
        client.startLiveStreaming(rtmpUrl, true);
        externalBroadcastUrl = rtmpUrl;
        addExternalTransmitionMiniView(rtmpUrl);
    }
}

function addExternalSource() {
    var externalUrl = $("#external-url").val();
    var width = parseInt($("#external-window-scale-width").val(), 10);
    var height = parseInt($("#external-window-scale-height").val(), 10);

    var injectStreamConfig = {
        width: width,
        height: height,
        videoBitrate: parseInt($("#external-video-bitrate").val(), 10),
        videoFramerate: parseInt($("#external-framerate").val(), 10),
        audioSampleRate: parseInt($("#external-audio-sample-rate").val(), 10),
        audioBitrate: parseInt($("#external-audio-bitrate").val(), 10),
        audioChannels: parseInt($("#external-audio-channels").val(), 10),
        videoGop: parseInt($("#external-video-gop").val(), 10)
    };

    // set live transcoding config
    client.addInjectStreamUrl(externalUrl, injectStreamConfig);
    injectedStreamURL = externalUrl;
    // TODO: ADD view for external url (similar to rtmp url)
}

// RTMP Connection (UI Component)
function addExternalTransmitionMiniView(rtmpUrl) {
    var container = $("#rtmp-controlers");
    // append the remote stream template to #remote-streams
    container.append(
        $("<div/>", {
            id: "rtmp-container",
            class: "container row justify-content-end mb-2"
        }).append(
            $("<div/>", { class: "pulse-container" }).append(
                $("<button/>", {
                    id: "rtmp-toggle",
                    class: "btn btn-lg col-flex pulse-button pulse-anim mt-2"
                })
            ),
            $("<input/>", {
                id: "rtmp-url",
                val: rtmpUrl,
                class: 'form-control col-flex" value="rtmps://live.facebook.com',
                type: "text",
                disabled: true
            }),
            $("<button/>", {
                id: "removeRtmpUrl",
                class: "btn btn-lg col-flex close-btn"
            }).append($("<i/>", { class: "fas fa-xs fa-trash" }))
        )
    );

    $("#rtmp-toggle").click(function() {
        if ($(this).hasClass("pulse-anim")) {
            client.stopLiveStreaming(externalBroadcastUrl);
        } else {
            client.startLiveStreaming(externalBroadcastUrl, true);
        }
        $(this).toggleClass("pulse-anim");
        $(this).blur();
    });

    $("#removeRtmpUrl").click(function() {
        client.stopLiveStreaming(externalBroadcastUrl);
        externalBroadcastUrl = "";
        $("#rtmp-container").remove();
    });
}



// UI buttons
function enableUiControls() {

    $("#mic-btn").click(function(){
        toggleMic();
    });

    $("#video-btn").click(function(){
        toggleVideo();
    });

    $("#exit-btn").click(function(){
        swal({
                title: "",
                text: "Do you want to leave this Session",
                type:'error',
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "Yes",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if(isConfirm) {
                    leaveChannel();
                } else {
                    return false;
                }
            }
        );
        // if (confirm('Do you want to leave this page')) {
        //     leaveChannel();
        //     alert('You ended this session');
        // }
    });

    $("#share-sreen-btn").click(function(){
        toggleBtnShare();
    });

    $("#start-RTMP-broadcast").click(function(){
        startLiveTranscoding();
        $('#addRtmpConfigModal').modal('toggle');
        $('#rtmp-url').val('');
    });

    $("#add-external-stream").click(function(){
        addExternalSource();
        $('#add-external-source-modal').modal('toggle');
    });

    // keyboard listeners
    $(document).keypress(function(e) {
        // ignore keyboard events when the modals are open
        if (($("#addRtmpUrlModal").data('bs.modal') || {})._isShown ||
            ($("#addRtmpConfigModal").data('bs.modal') || {})._isShown){
            return;
        }

        switch (e.key) {
            case "m":
                console.log("squick toggle the mic");
                toggleMic();
                break;
            case "v":
                console.log("quick toggle the video");
                toggleVideo();
                break;
            case "q":
                console.log("so sad to see you quit the channel");
                leaveChannel();
                break;
            default:  // do nothing
        }
    });
}

function toggleBtn(btn){
    btn.toggleClass('btn-dark').toggleClass('btn-danger');
}

function toggleVisibility(elementID, visible) {
    if (visible) {
        $(elementID).attr("style", "display:block");
    } else {
        $(elementID).attr("style", "display:none");
    }
}

function toggleMic() {
    $("#mic-btn").toggleClass('mute-audio').toggleClass('unmute-audio'); // toggle the mic icon
    if ($("#mic-btn").hasClass('mute-audio')) {
        localStreams.camera.stream.unmuteAudio(); // enable the local mic
    } else {
        localStreams.camera.stream.muteAudio(); // mute the local mic
    }
}

function toggleVideo() {
    if ($("#video-btn").hasClass('mute-video')) {
        localStreams.camera.stream.muteVideo(); // enable the local video
        console.log("muteVideo");
    } else {
        localStreams.camera.stream.unmuteVideo(); // disable the local video
        console.log("unMuteVideo");
    }
    $("#video-btn").toggleClass('mute-video').toggleClass('unmute-video'); // toggle the video icon
}

function toggleBtnShare() {
    if ($("#share-sreen-btn").hasClass('share-screen-off')) {
        //$('#stream-player-'+localStreams.uid+'').remove();
        screenClient.init(
            agoraAppId,
            function () {
                console.log("AgoraRTC client initialized");
                joinSharing();
            },
            function (err) {
                console.log("[ERROR] : AgoraRTC client init failed", err);
            }
        );
    } else {
        leaveSharing();
    }
    $("#share-sreen-btn").toggleClass('share-screen-off').toggleClass('share-screen-on'); // toggle the share screen icon
}

// keep the spinners honest
$("input[type='number']").change(event, function() {
    var maxValue = $(this).attr("max");
    var minValue = $(this).attr("min");
    if($(this).val() > maxValue) {
        $(this).val(maxValue);
    } else if($(this).val() < minValue) {
        $(this).val(minValue);
    }
});

// keep the background color as a proper hex
$("#background-color-picker").change(event, function() {
    // check the background color
    var backgroundColorPicker = $(this).val();
    if (backgroundColorPicker.split('#').length > 1){
        backgroundColorPicker = '0x' + backgroundColorPicker.split('#')[1];
        $('#background-color-picker').val(backgroundColorPicker);
    }
});
function initializeUi() {
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