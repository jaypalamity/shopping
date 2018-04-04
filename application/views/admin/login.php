<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="container">
            <h2>Login</h2>
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('message') ?> </div>

            <?php } if ($this->session->flashdata('msg-error')) { ?>
                <div class="alert alert-danger"> <?= $this->session->flashdata('msg-error'); ?> </div>
            <?php } ?>
            <form action="<?php echo base_url('backoffice/login/logincheck'); ?>" method="post">
                <div class="form-group">
                    <label for="username">Email:</label>
                    <input type="text" class="form-control" value="<?php echo @$_COOKIE['username']; ?>" id="username" placeholder="Enter email" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" value="<?php echo @$_COOKIE['password']; ?>" id="username" placeholder="Enter password" name="password">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="remember_me" <?php
                        if (isset($_COOKIE['password'])) {
                            echo 'checked="checked"';
                        } else {
                            echo '';
                        }
                        ?> value="1"> Remember me</label>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>

    </body>
</html>
