<?php
require_once('../view/header.php');
?>

<body>
    <div class="container">
        <h1>File uploaded successfully</h1>
        <embed src="<?= TEMP_PDF . $fileName; ?>" type="application/pdf" class="showpdf"></embed>
        <a href="<?= BASE_URL . 'model/subscribers.php' ?>" class="btn btn-primary btn-lg mt-3">
            go to list of subscribers
        </a>
    </div>
</body>

</html>