<?php
include_once(__DIR__ . '/view/header.php');
?>

<body>
    <div class="container">
        <h1>upload pdf-file</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="fileToUpload" class="form-label">Select file:</label>
                <input class="form-control form-control-lg" id="fileToUpload" type="file" name="fileToUpload">
            </div>
            <button type="submit" class="btn btn-primary btn-lg mt-3">Upload</button>
        </form>
    </div>
</body>

</html>