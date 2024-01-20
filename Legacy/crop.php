<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crop Test</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="test/Croppie/Croppie-master/Croppie-master/croppie.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="test/Croppie/Croppie-master/Croppie-master/croppie.css">
<script type="text/javascript" src="assets/js/upload.js"></script>
<link rel="stylesheet" href="test/Croppie/Croppie-master/Croppie-master/demo.css">


</head>

<body>



        <div class="container">
            <h2>Crop Image and Upload using jQuery and PHP <a href="http://foliotek.github.io/Croppie/" target="_parent">http://foliotek.github.io/Croppie/</a></h2>	 
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div id="upload-image"></div>
                    </div>
                    <div class="col-md-4">
                        <strong>Select Image:</strong>
                        <br/>
                        <input type="file" id="images">
                        <br/>
                        <button class="btn btn-success cropped_image">Upload Image</button>
                    </div>			
                    <div class="col-md-4 crop_preview">
                        <div id="upload-image-i"></div>
                    </div>
                </div>
              </div>
            </div>			
        </div>


</body>
</html>