<?php
include_once(__DIR__ . '/header.php');
?>

<body>
    <div class="container">
        <h1>Sending has finished.</h1>
        <h2>Emails were sent.</h2>
        <h3><?= $send_mail_ok; ?></h3>
        <h2>telegram were sent.</h2>
        <h2><?= $send_telegram_ok; ?></h2>

        <a href="/" class="btn btn-primary btn-lg mt-3">upload pdf again</a>
    </div>
</body>

</html>