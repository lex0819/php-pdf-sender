<?php
include_once(__DIR__ . '/header.php');
?>

<body>
    <div class="container">
        <h1>File uploaded successfully</h1>
        <embed src="<?= $uploadPath . $fileName; ?>" type="application/pdf" class="showpdf"></embed>
        <a href="subscribers.php" class="btn btn-primary btn-lg mt-3">
            go to list of subscribers
        </a>
    </div>
</body>

</html>