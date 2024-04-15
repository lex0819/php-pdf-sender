<?php
require_once('./model/init.php');
require_once('./view/header.php');
?>

<body>
    <div class="container mt-3">
        <h1 class="mb-3">Test service</h1>
        <h2 class="mb-3">upload pdf-file</h2>
        <p class="fs-5">The service provides uploading, PDF-file and then sending it by list of emails and list of telegrams.</p>
        <p class="fs-5">You can add to telegram list only real addresses form users who allowed it. Your users must be linked to my bot before.</p>
        <p class="fs-5 mb-3">The bot is <a target="_blank" href="https://t.me/pdf0819sender0819bot">t.me/pdf0819sender0819bot</a></p>
        <ol class="fs-3 mb-3">
            <li>Firstly you upload PDF</li>
            <li>then you add and check list of your users who will be send PDF</li>
            <li>then you send PDF</li>
            <li>That's all</li>
        </ol>
        <h2 class="mb-3">Let's go!</h2>
        <form action="./model/upload.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="fileToUpload" class="form-label">Select file:</label>
                <input class="form-control form-control-lg" id="fileToUpload" type="file" name="fileToUpload">
            </div>
            <button type="submit" class="btn btn-primary btn-lg mt-3">Upload</button>
        </form>
    </div>
</body>

</html>