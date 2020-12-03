<?php
if(isset($_POST['posttitle'])){
    $font=realpath('Gabriola.ttf');
    $image=imagecreatefromjpeg("templates/temp_1.jpg");
    $color=imagecolorallocate($image,19,21,22);
    imagettftext($image,60,0,320,320,$color,$font,$_POST['posttitle']);
    imagettftext($image,20,0,500,460,$color,$font,$_POST['postdescription']);
    imagettftext($image,40,0,450,840,$color,$font,$_POST['authorname']);
    $date=$_POST['authorname'];
    
    // Upload Signature
    if(isset($_FILES['Signature'])){
        $errors= array();
        $file_name = $_FILES['Signature']['name'];
        $file_size =$_FILES['Signature']['size'];
        $file_tmp =$_FILES['Signature']['tmp_name'];
        $file_type=$_FILES['Signature']['type'];
        $tmp = explode('.',$_FILES['Signature']['name']);
        $file_ext=strtolower(end($tmp));
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > 2097152){
            $errors[]='File size must be exactely 2 MB';
        }
        
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"./uploads/".$file_name);
            echo "<script>alert('Success')</script>";
        }else{
            print_r($errors);
        }
    }
    
    // Merge Images
    $src = imagecreatefromjpeg("./uploads/".$file_name);
    
    imagealphablending($image, false);
    imagesavealpha($image, true);
    
    imagecopymerge($image, $src, 144, 440, 50, 50, 300, 210, 100); //have to play with these numbers for it to work for you, etc.

    imagedestroy($src);

    $file=$_POST['posttitle'].time();
    imagejpeg($image,"certificate/".$file.".jpg");
    imagedestroy($image);
    
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>poster generatorr</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/main.css">

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>

</head>
<body>
<div class="container">
<div style="text-align:center">
<h2>poster generator</h2>
<p>Create poster in a second</p>
</div>
<div class="row">
<div class="column_input">
<form method="post" action="index.php" enctype="multipart/form-data">
<!--                Enter name-->
<label for="posttitle">Title of poster</label>
<input type="text" id="posttitle" name="posttitle" placeholder="Title of post">
<!--                Enter Event Name-->
<label for="signature">Upload Post Image</label>
<input type="file" name="Signature" id="Signature" placeholder="Upload Post Image">
<br><br>
<div class="form-group">
<label for="Post"><span class="fieldinfo">Post description:</span></label>
<input type="text" id="postdescription" name="postdescription" placeholder="Description about post">
</div>
<label for="authorname">Author Name</label>
<input type="text" id="authorname" name="authorname" placeholder="author name">
<!--                Enter date of issue-->

<br><br>


</div>
<br><br>
<input type="submit" value="Generate poster">
</form>
</div>
<br><br>
<div class="column_output">
<img src="templates/temp_1.jpg" alt="image" style="width:70%">
</div>

</div>
</div>

</body>
</html>
