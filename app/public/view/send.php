<?php
require_once('../view/header.php');
?>

<body>
    <div class="container">
        <h1>Results of the sending.</h1>
        <h2>Emails:</h2>
        <div class="text-left">
            <?php foreach ($errors as $error) : ?>
                <div class="row">
                    <?= $error; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-left">
            <?php foreach ($success as $ok) : ?>
                <div class="row fs-5">
                    <div class="col">
                        <?= $ok; ?>
                    </div>
                    <div class="col">
                        OK
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Telegrams: </h2>
        <div class="text-left">
            <?php foreach ($send_telegram_ok as $key => $value) : ?>
                <div class="row fs-5">
                    <div class="col">
                        <?= $key; ?>
                    </div>
                    <div class="col">
                        <?php echo $value ? 'OK' : 'fail'; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/" class="btn btn-primary btn-lg mt-3">upload pdf again</a>
    </div>
</body>

</html>