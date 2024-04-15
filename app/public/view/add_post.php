<?php
require_once('../view/header.php');
?>

<body>
    <div class="container">
        <h1>Add new subscriber</h1>
        <div class="alert alert-primary" role="alert">
            You can fill only one address field, or email or telegram.
        </div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="<?= htmlspecialchars($_SESSION['name']) ?>">
            </div>
            <?php if (isset($_SESSION['errors_name'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_SESSION['errors_name']) ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= htmlspecialchars($_SESSION['email']) ?>">
            </div>
            <?php if (isset($_SESSION['errors_email'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_SESSION['errors_email']) ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Telegram</label>
                <input type="text" class="form-control" id="telegram" name="telegram" placeholder="@example" value="<?= htmlspecialchars($_SESSION['telegram']) ?>">
            </div>
            <?php if (isset($_SESSION['errors_telegram'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_SESSION['errors_telegram']) ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary btn-lg mt-3">OK</button>
        </form>
    </div>
</body>

</html>