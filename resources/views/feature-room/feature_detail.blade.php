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
                <button onclick="take_snapshot()" id="click_btn" class="mt-2"><i class="bi bi-camera"></i></button>
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
Webcam.set({
   image_format: 'jpeg',
   jpeg_quality: 90,
   audio: true, video: { facingMode: { exact: "environment" } }
});
Webcam.attach( '#camera' );

function take_snapshot(){
    Webcam.snap( function(data_uri) {
    document.getElementById('results').innerHTML = 
     '<img src="'+data_uri+'" class="responsive"/>';
    //  document.getElementById('click_btn').style.display = "none";
     canvasContainer();
} );
// Webcam.reset();
}

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
function canvasContainer(){
    html2canvas(document.querySelector("#webcan_container")).then(canvas => {
    document.querySelector('.download').href = canvas.toDataURL();
    document.querySelector('.download').download = " ";
});
}

</script>
@endsection