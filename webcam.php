<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width" />
    <!-- Required library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        #my_camera{
          transform: scaleX(-1);  
        }
    </style>
    <title>Test Web Cam</title>
</head>
<body>
<div class="container">    
  <div class="row">
    <div class="col-lg-6" align="center">
        <label>Web Camera</label>
        <div id="my_camera" class="pre_capture_frame"></div>
        <input type="hidden" name="captured_image_data" id="captured_image_data">
        <br>
        <input type="button" class="btn btn-info btn-round btn-file" value="Take Snapshot" onClick="startTimer()">    
        <!-- Menambahkan elemen audio -->
        <audio id="snapSound" src="sound/capture.mp3"></audio>
        <audio id="sanpDelay" src="sound/delay.mp3"></audio>
    </div>
    <div class="col-lg-6" align="center">
        <label>Result</label>
        <div id="results">
            <img style="width: 350px;" class="after_capture_frame"/>
        </div>
        <br>
        <button type="button" class="btn btn-success" onclick="saveSnap()">Save gambar</button>
    </div>    
  </div><!--  end row -->
</div><!-- end container -->
<br>
<!-- Menambahkan elemen untuk menampilkan timer -->
<div id="timer" style="text-align: center; font-size: 20px;"></div>
</body>
<script language="JavaScript">
     // Configure a few settings and attach camera 250x187
     Webcam.set({
      width: 500,
      height: 500,
      image_format: 'jpeg',
      jpeg_quality: 90
     });     
     Webcam.attach( '#my_camera' );

    function startTimer() {
		let audio = $("#sanpDelay")[0];
		audio.play();
        // Menampilkan timer
        var soundTime = 6;
        var timer = 5;
        var timerElement = document.getElementById('timer');
        timerElement.innerHTML = 'Snapshot akan diambil dalam ' + timer + ' detik';

        var countdown = setInterval(function() {
            timer--;
			soundTime--;
            timerElement.innerHTML = 'Snapshot akan diambil dalam ' + timer + ' detik';
            if (soundTime <= 0) {
                clearInterval(countdown);
                take_snapshot();
                timerElement.innerHTML = '';
            }
        }, 1000);
    }

    function take_snapshot() {
        var audio = $("#snapSound")[0];
        audio.play();
         Webcam.snap( function(data_uri) {
         document.getElementById('results').innerHTML = 
          '<img class="after_capture_frame" src="'+data_uri+'"/>';
         $("#captured_image_data").val(data_uri);
         });     
    }

    function saveSnap(){
    var base64data = $("#captured_image_data").val();
     $.ajax({
            type: "POST",
            dataType: "json",
            url: "capture_image_upload.php",
            data: {image: base64data},
            success: function(data) { 
                alert(data);
            }
        });
    }
</script>
</html>