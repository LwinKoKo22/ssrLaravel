@extends('feature-room.layouts.app')
@section('content')
<div class="card my-3 shadow">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <p>Feature Detail</p>
            <a href="/" class="btn btn-theme"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body px-4">
        <div class="row">
            <div class="col-12 webcan-container p-0" id="webcan_container">
                <img src="{{ $feature->feature_image_path() }}" alt="" width="100%" height="550px">
                <div id="camera"></div>
                <div id="results"></div>
           </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button onclick="start_camera()"id="start_camera" class="mt-2"><i class="bi bi-camera-fill"></i></button>
                <button onclick="take_snapshot()" id="click_btn" class="mt-2" style="display: none;"><i class="bi bi-camera"></i></button>
                <button onclick="back_camera()" id="rotate_btn" class="mt-2"><i class="bi bi-arrow-clockwise"></i></button>
                <button onclick="reverse_camera()" id="reverse_btn" class="mt-2" style="display: none;"><i class="bi bi-arrow-counterclockwise"></i></button>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <input type="file" id="upload_file" class="form-control">
            </div>
            <div class="col-6 text-end">
                <a class="download btn btn-theme" href=""><i class="bi bi-check-circle-fill"></i> Save</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" ></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>

//Front Camera 
function frontCamera(){
    Webcam.set({
   image_format: 'jpeg',
   jpeg_quality: 90,
   audio: true, video: { facingMode: { exact: "environment" } }
});
Webcam.attach( '#camera' );
}

//Capture Photo
function take_snapshot(){
    Webcam.snap( function(data_uri) {
    document.getElementById('results').innerHTML = 
     '<img src="'+data_uri+'" class="responsive"/>';
     document.getElementById('click_btn').style.display = "none";
     document.getElementById('start_camera').style.display = "block";
     canvasContainer();
} );
Webcam.reset();
}

//To start the task
function start_camera(){
frontCamera();
document.getElementById('results').innerHTML = "";
document.getElementById('click_btn').style.display = "block";
document.getElementById('start_camera').style.display = "none";
}

//File upload
let upload_file = document.getElementById('upload_file');
upload_file.addEventListener("change",e=>{
    const file = upload_file.files[0];
    const reader = new FileReader();
    reader.addEventListener('load',()=>{
       let data = reader.result;
       document.getElementById('results').innerHTML = 
     '<img src="'+data+'" />';
     document.getElementById('click_btn').style.display = "none";
     Webcam.reset();
     canvasContainer();
    })
     reader.readAsDataURL(file);
})

//download photo 
function canvasContainer(){
    html2canvas(document.querySelector("#webcan_container")).then(canvas => {
    document.querySelector('.download').href = canvas.toDataURL();
    document.querySelector('.download').download = " ";
});
}

//Back Camera
function back_camera(){
    document.getElementById('results').innerHTML = "";
    Webcam.set({
   width: 320,
   height: 250,
   image_format: 'jpeg',
   jpeg_quality: 90,
   constraints: {
    video : true,
   facingMode: 'environment'
   }
});
Webcam.attach( '#camera' );
document.getElementById('click_btn').style.display = "block";
document.getElementById('start_camera').style.display = "none";
document.getElementById('reverse_btn').style.display = 'block';
document.getElementById('rotate_btn').style.display = "none";
}

//reverse button
function reverse_camera(){
    document.getElementById('results').innerHTML = "";
    Webcam.set({
   image_format: 'jpeg',
   jpeg_quality: 90,
   audio: true, video: { facingMode: { exact: "environment" } }
});
Webcam.attach( '#camera' );
document.getElementById('click_btn').style.display = "block";
document.getElementById('start_camera').style.display = "none";
document.getElementById('reverse_btn').style.display = 'none';
document.getElementById('rotate_btn').style.display = "block";
}
</script>
@endsection