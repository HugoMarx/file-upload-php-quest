<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>File Upload Quest</title>

</head>

<body>



    <?php
    //var_dump($_FILES);
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {

        $myFile = uniqid('QUEST_') . $_FILES['monfichier']['name'];
        //echo $myFile;
        $uploadDir = 'C:\Users\****\desktop\file_upload_quest\upload\\';

        $uploadPath = $uploadDir . basename($myFile);

        $valideExtensions = ['jpg', 'JPG', 'jpeg', 'png', 'gif', 'webp'];
        $fileExtension = pathinfo($_FILES['monfichier']['name'], PATHINFO_EXTENSION);

        $maxFileSize = 1048576;

        if ($_FILES['monfichier']['size'] < $maxFileSize) {

            if (in_array($fileExtension, $valideExtensions) && $_FILES['monfichier']['error'] === 0) {
                move_uploaded_file($_FILES['monfichier']['tmp_name'], $uploadPath);
                $message = 'Upload successfull';
                $fileDisplay = '<img src="/upload/' . $myFile . '" alt="">';
                $fileOk = true;
            } else if ($_FILES['monfichier']['error'] != 0) {
                $message =  'ERROR ' . $_FILES['monfichier']['error'];
            } else {
                $message =  'this file extension is not supported';
                $fileOk = false;
            }
        } else {
            $message = 'File must not be over 1MB';
            $fileOk = false;
        }
    } ?>


    <h3>Uploadez votre fichier ici :</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="monfichier">
        <input type="submit" value="Upload file">
    </form>

    <?php if (isset($_FILES['monfichier']['name']) && @$fileOk != false) {

        echo  '<div style="text-align: center;">';
        echo  @$fileDisplay;
        echo '<h3>' . $message . '</h3>';
        echo '<a href="_form.php?delfile=' . $uploadPath . '"><button>Delete</button></a>';

        echo   '</div>';
    } else {
        echo '<h3 style="text-align: center;">' . @$message . '</h3>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delfile'])) {

        unlink($_GET['delfile']);

        $message = 'File successfully deleted';

        echo  '<div style="text-align: center;">';
        echo '<h3>' . $message . '</h3>';
        echo   '</div>';
    }
    ?>

</body>

</html>