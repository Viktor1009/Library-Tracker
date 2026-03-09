<?php
function displayMsg($type, $string){
    echo " <div class='alert alert-{$type}' role='alert'>
                <p>{$string}</p>
            </div>
        ";
}

function uploadImg($i, $conn, $project_id){
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["files"]["name"][$i]);
    $ogtarget = $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    

    // Check if image file is a actual image or fake image
    if($_POST["posttype"] === "new_project") {
        $check = getimagesize($_FILES["files"]["tmp_name"][$i]);
        if($check !== false)
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file))
    {
        $index = 1;
        $target_file = $target_dir . pathinfo($ogtarget,PATHINFO_FILENAME) . "-" . $index . "." . $imageFileType;
        while(file_exists($target_file)) {
            $index = $index + 1;
            $target_file = $target_dir . pathinfo($ogtarget,PATHINFO_FILENAME) . "-" . $index . "." . $imageFileType;
        }
        echo "New name: " . $target_file;
    }

    // Check file size
    if ($_FILES["files"]["size"][$i] > 500000)
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" )
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    }
    else {
        if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file))
        {
            echo "The file ". htmlspecialchars( basename( $_FILES["files"]["name"][$i])). " has been uploaded.";

            $sql = "INSERT INTO image (image_url, project_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $target_file, $project_id);
            $stmt->execute();
            $stmt->close();
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    return $target_file;
}
function createThumbnail($sourcePath){
    $pathInfo = pathinfo($sourcePath);
    $destPath = $pathInfo['dirname'] . "/" . $pathInfo['filename'] . "-thumb." . $pathInfo['extension'];

    $imageInfo = getimagesize($sourcePath);
    if (!$imageInfo) return false;

    $mime = $imageInfo['mime'];
    $im = null;

    switch ($mime) {
        case 'image/jpeg':
            $im = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $im = imagecreatefrompng($sourcePath);
            break;
        default:
            return false;
    }

    if ($im) {
        $size = min(imagesx($im), imagesy($im));
        $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);

        if ($im2 !== FALSE) {
            // Spara den nya bilden beroende på filtyp
            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($im2, $destPath);
                    break;
                case 'image/png':
                    imagepng($im2, $destPath);
                    break;
            }
            imagedestroy($im2); // Städa upp minnet
        }
        imagedestroy($im); // Städa upp minnet
    }
    return $destPath;
}
function makeTabel($conn, $sql, $name) {
    try {
        $conn->query($sql);
        displayMsg("success", "Tabel " . $name . " created successfully");
    } catch(mysqli_sql_exception $e){
        displayMsg("error",  $name . " already exists");
    }
}
function makeEnv(){
    $env = [
        'DB_HOST' => $_POST["host"],
        'DB_PORT' => '3306',
        'DB_DATABASE' => $_POST["dbname"],
        'DB_USER' => $_POST["dbuser"],
        'DB_PASSWORD' => $_POST["dbpass"],
    ];
    $content = "";
    foreach ($env as $key => $value) {
        $content .= "{$key}={$value}\n";
    }    

    $file = __DIR__ . '/.env';
    if (file_put_contents($file, $content)) {
        displayMsg("success", "All done");
    } else {
        echo "Något knas";
    }

}