<?php
$name = '';
$type = '';
$size = '';
$error = '';
function compress_image($source_url, $destination_url, $quality)
{

    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}

if ($_POST) {

    if ($_FILES["file"]["error"] > 0) {
        $error = $_FILES["file"]["error"];
    } else if (($_FILES["file"]["type"] == "image/gif") ||
        ($_FILES["file"]["type"] == "image/jpeg") ||
        ($_FILES["file"]["type"] == "image/png") ||
        ($_FILES["file"]["type"] == "image/pjpeg")
    ) {

        $url = 'destination .jpg';

        $filename = compress_image($_FILES["file"]["tmp_name"], $url, 80);
        $buffer = file_get_contents($url);

        /* Force download dialog... */
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        /* Don't allow caching... */
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        /* Set data type, size and filename */
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . strlen($buffer));
        header("Content-Disposition: attachment; filename=$url");

        /* Send our file... */
        echo $buffer;
    } else {
        $error = "Uploaded image should be jpg or gif or png";
    }
}
?>
<html>

<head>
    <title>Php code compress the image</title>
</head>

<body>

    <div class="message">
        <?php
        if ($_POST) {
            if ($error) {
        ?>
        <label class="error"><?php echo $error; ?></label>
        <?php
            }
        }
        ?>
    </div>
    <fieldset class="well">
        <legend>Upload Image:</legend>
        <form action="" name="myform" id="myform" method="post" enctype="multipart/form-data">
            <ul>
                <li>
                    <label>Upload:</label>
                    <input type="file" name="file" id="file" />
                </li>
                <li>
                    <input type="submit" name="submit" id="submit" class="submit btn-success" />
                </li>
            </ul>
        </form>
    </fieldset>
</body>

</html>