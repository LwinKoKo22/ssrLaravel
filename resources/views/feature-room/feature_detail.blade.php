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
            <div class="col-12 ">
                <div class="">
                    <div class="d-flex justify-content-center">
                        <button id="start_camera" class="mt-2 me-2"><i class="bi bi-camera-fill"></i></button>
                        <button  id="click_btn" class="mt-2 me-2" style="display: none;"><i class="bi bi-camera"></i></button>
                        <button  id="front_camera" class="mt-2 me-2"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>
                </div>
                {{-- <button onclick="start_camera()" id="reverse_btn" class="mt-2" style="display: none;"><i class="bi bi-arrow-counterclockwise"></i></button> --}}
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

let camera = document.getElementById('camera');
let result = document.getElementById('results');
let start = document.getElementById('start_camera');
let click = document.getElementById('click_btn');
let front = document.getElementById('front_camera');
//To start the task
start.addEventListener('click',function(){
    result.innerHTML = "  ";
    Webcam.set({
   width: 320,
   height: 250,
   image_format: 'jpeg',
   jpeg_quality: 90,
   constraints: {
    video : true,
   }
});
    Webcam.attach('camera');
    start.style.display = "none";
    click.style.display = "block";
})

//Capture Photo Process
function snapShoot(){
    Webcam.snap( function(data_uri) {
    document.getElementById('results').innerHTML = 
     '<img src="'+data_uri+'" class="responsive"/>';
     document.getElementById('click_btn').style.display = "none";
     document.getElementById('start_camera').style.display = "block";
     canvasContainer();
} );
Webcam.reset();
}

//Capture Photo
click.addEventListener('click',function(){
    snapShoot();
})

// function startCamera(){
//     Webcam.set({
//    width: 320,
//    height: 250,
//    image_format: 'jpeg',
//    jpeg_quality: 90,
//    constraints: {
//     video : true,
//    }
// });
// Webcam.attach( '#camera' );
// document.getElementById('results').innerHTML = "";
// document.getElementById('click_btn').style.display = "block";
// document.getElementById('start_camera').style.display = "none";
// }

//Front Camera 
front.addEventListener('click',function(){
    result.innerHTML = "  ";
    Webcam.set({
        width: 320,
        height: 250,
        image_format: 'jpeg',
        constraints: {
            facingMode: 'environment'
        }
    });
    Webcam.attach( 'camera' );
    start.style.display = "none";
    click.style.display = "block";
})

//File upload
let upload_file = document.getElementById('upload_file');
upload_file.addEventListener("change",e=>{
    const file = upload_file.files[0];
    const reader = new FileReader();
    reader.addEventListener('load',()=>{
        let data = reader.result;
        result.innerHTML ='<img src="'+data+'" />';
        click.style.display = "none";
        Webcam.reset();
        canvasContainer();
    })
        reader.readAsDataURL(file);
})

// download photo 
function canvasContainer(){
    html2canvas(document.querySelector("#webcan_container")).then(canvas => {
    document.querySelector('.download').href = canvas.toDataURL();
    document.querySelector('.download').download = " ";
});
}

//Back Camera
// function back_camera(){
//     document.getElementById('results').innerHTML = "";
//     frontCamera()
// Webcam.attach( '#camera' );
// document.getElementById('click_btn').style.display = "block";
// document.getElementById('start_camera').style.display = "none";
// document.getElementById('rotate_btn').style.display = "none";
// }

//reverse button
// function reverse_camera(){
// frontCamera();
// document.getElementById('results').innerHTML = "";
// document.getElementById('click_btn').style.display = "block";
// document.getElementById('start_camera').style.display = "none";
// document.getElementById('reverse_btn').style.display = 'none';
// document.getElementById('rotate_btn').style.display = "block";
// }
</script>
@endsection