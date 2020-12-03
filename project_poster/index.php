<?php
if(isset($_POST['posttitle'])){
    $font=realpath('Gabriola.ttf');
    $image=imagecreatefromjpeg("templates/temp_1.jpg");
    $color=imagecolorallocate($image,19,21,22);
    imagettftext($image,60,0,320,320,$color,$font,$_POST['posttitle']);
    imagettftext($image,20,0,500,460,$color,$font,$_POST['postdescription']);
    imagettftext($image,40,0,450,840,$color,$font,$_POST['authorname']);
    $date=$_POST['authorname'];
    
    
    $extensions= array("jpeg","jpg","png");
    
    // Upload Signature
    if(isset($_FILES['Signature'])){
        $errors= array();
        $signature_file_name = $_FILES['Signature']['name'];
        $signature_file_size =$_FILES['Signature']['size'];
        $signature_file_tmp =$_FILES['Signature']['tmp_name'];
        $signature_file_type=$_FILES['Signature']['type'];
        $signature_tmp = explode('.',$_FILES['Signature']['name']);
        $signature_file_ext=strtolower(end($signature_tmp));
        
        
        if(in_array($signature_file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($signature_file_size > 2097152){
            $errors[]='File size must be exactely 2 MB';
        }
        
        if(empty($errors)==true){
            move_uploaded_file($signature_file_tmp,"./uploads/".$signature_file_name);
        }else{
            print_r($errors);
        }
    }
    
    // Upload Author's Image
    if(isset($_FILES['AuthorImage'])){
        $errors= array();
        $authorImage_file_name = $_FILES['AuthorImage']['name'];
        $authorImage_file_size =$_FILES['AuthorImage']['size'];
        $authorImage_file_tmp =$_FILES['AuthorImage']['tmp_name'];
        $authorImage_file_type=$_FILES['AuthorImage']['type'];
        $authorImage_tmp = explode('.',$_FILES['AuthorImage']['name']);
        $authorImage_file_ext=strtolower(end($authorImage_tmp));
        
        
        if(in_array($authorImage_file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($authorImage_file_size > 2097152){
            $errors[]='File size must be exactely 2 MB';
        }
        
        if(empty($errors)==true){
            move_uploaded_file($authorImage_file_tmp,"./uploads/".$authorImage_file_name);
            echo "<script>alert('Success')</script>";
        }else{
            print_r($errors);
        }
    }
    
    // Merge Images
    $signature_src = imagecreatefromjpeg("./uploads/".$signature_file_name);
    $authorImage_src = imagecreatefromjpeg("./uploads/".$authorImage_file_name);
    
    // Make it Circular    
    /*
    $x=imagesx($authorImage_src)-100 ;
    $y=imagesy($authorImage_src)-100;    
    
    $img2 = imagecreatetruecolor($x, $y);
    $bg = imagecolorallocate($img2, 255, 255, 255); 
    imagefill($img2, 0, 0, $bg);
    
    $e = imagecolorallocate($img2, 0, 0, 0); 
    
    $r = $x <= $y ? $x : $y; 
    imagefilledellipse ($img2, ($x/2), ($y/2), $r, $r, $e); 
    
    imagecolortransparent($img2, $e);
    
    imagecopymerge($authorImage_src, $img2, 0, 0, 0, 0, $x, $y, 100);
    
    imagecolortransparent($authorImage_src, $bg);
    */
    imagealphablending($image, false);
    imagesavealpha($image, true);
    
    imagecopymerge($image, $signature_src, 144, 440, 50, 50, 300, 210, 100);
    imagecopymerge($image, $authorImage_src, 280, 790, 50, 50, 100, 100, 100);
    
    imagedestroy($signature_src);
    imagedestroy($authorImage_src);
    
    $file=$_POST['posttitle'].time();
    imagejpeg($image,"certificate/".$file.".jpg");
    imagedestroy($image);
    
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Poster Generator</title>
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
            <label for="posttitle">Title of poster</label>
            <input type="text" id="posttitle" name="posttitle" placeholder="Title of post">
            <label for="signature">Upload Post Image</label>
            <input type="file" name="Signature" id="Signature" placeholder="Upload Post Image">
                     <br><br>
            <label for="Post"><span class="fieldinfo">Post description:</span></label>
            <input type="text" id="postdescription" name="postdescription" placeholder="Description about post">
            <label for="authorname">Author Name</label>
            <input type="text" id="authorname" name="authorname" placeholder="author name">
            <label for="AuthorImage">Upload Author's Image</label>
            <input type="file" name="AuthorImage" id="AuthorImage" placeholder="Upload Author's Image">
            <input type="submit" value="Generate poster">
        </form><button type="submit" onclick="window.open('./certificate/<?php echo $file.'.jpg' ;?>')">Download Poster</button>
  </div>
</div>
                      <br><br>
<div class="column_output">
     <img src="templates/temp_1.jpg" alt="image" style="width:70%">
</div>

</body>
</html>
