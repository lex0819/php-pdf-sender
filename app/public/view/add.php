<?php
include_once(__DIR__ . '/header.php');
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
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Telegram</label>
                <input type="text" class="form-control" id="telegram" name="telegram" placeholder="@example">
            </div>
            <button type="submit" class="btn btn-primary btn-lg mt-3">OK</button>
        </form>
    </div>
</body>

</html>