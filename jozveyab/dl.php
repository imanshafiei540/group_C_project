<?php
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

    $expensions= array("gif","pdf","doc","docx");

    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a PDF or DOCx file.";
    }

    if($file_size > 21097152){
        $errors[]='File size must be excately 20 MB';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"uploads/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}
?>
<html>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" />
    <input type="submit"/>
</form>
<form action="" method="post" >
    <button name="btn-download" type="submit">Download</button>
</form>

</body>
</html>
<?php
$file = 'uploads/monkey.gif';

if ( isset($_POST['btn-download']) && file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>