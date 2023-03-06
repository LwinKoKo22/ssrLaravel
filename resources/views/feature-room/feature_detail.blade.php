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
                        <button id="reverse_camera" class="mt-2 me-2" style="display:none;"><i class="bi bi-camera2"></i></button>
                        <button id="reverse_click" class="mt-2 me-2" style="display:none;"><i class="bi bi-camera-fill"></i></button>
                        <button  id="click_btn" class="mt-2 me-2" style="display: none;"><i class="bi bi-camera"></i></button>
                        <button  id="front_camera" class="mt-2 me-2"><i class="bi bi-arrow-clockwise"></i></button>
                        <button  id="reverse_btn" class="mt-2" style="display: none;"><i class="bi bi-arrow-counterclockwise"></i></button>
                    </div>
                </div>
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
let reverse = document.getElementById('reverse_btn');
let reverse_camera = document.getElementById('reverse_camera');
let reverse_click  = document.getElementById('reverse_click');
//To start the task
function startCamera(){
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
}

start.addEventListener('click',function(){
    result.innerHTML = "  ";
    startCamera();
    start.style.display = "none";
    click.style.display = "block";
})

//Capture Photo Process
function snapShoot(){
    Webcam.snap( function(data_uri) {
    document.getElementById('results').innerHTML = 
     '<img src="'+data_uri+'" class="responsive"/>';
     canvasContainer();
} );
Webcam.reset();
}

//Capture Photo
click.addEventListener('click',function(){
    snapShoot();
    document.getElementById('click_btn').style.display = "none";
     document.getElementById('start_camera').style.display = "block";
     reverse_click.style.display = "none";
})

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
    click.style.display = "none";
    front.style.display = "none";
    reverse.style.display = "block";
    reverse_camera.style.display = "block"
})

reverse_camera.addEventListener('click',function(){
    snapShoot();
    document.getElementById('click_btn').style.display = "none";
    document.getElementById('start_camera').style.display = "none";
    document.getElementById('reverse_camera').style.display = "none";
    document.getElementById('reverse_click').style.display = "block";
})

reverse_click.addEventListener('click',function(){
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
    click.style.display = "none";
    front.style.display = "none";
    reverse.style.display = "block";
    reverse_camera.style.display = "block"
    reverse_click.style.display = "none";
})
//reverse btn
reverse.addEventListener('click',function(){
    result.innerHTML = "  ";
    startCamera();
    start.style.display = "none";
    click.style.display = "block";
    front.style.display = "block";
    reverse.style.display = "none";
    reverse_camera.style.display = "none";
    reverse_click.style.display = "none";
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

</script>
@endsection