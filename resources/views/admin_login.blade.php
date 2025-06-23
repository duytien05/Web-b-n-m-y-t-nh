<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">User Login</h3>
            <form method = "POST" action="{{URL::to('/admin-dashboard')}}" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    {{(csrf_field())}}
                    <label for="email">Email</label>
                    <input id="email" name ="admin_email" type="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name ="admin_password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember login</label>
                </div>
                <div class="form-group">
                    <?php
                        if ($message = Session::get('message')) {
                        ?>
                            <div class="alert alert-danger"><?php
                                echo $message;
                                Session::put('message',null);
                                ?></div>
                        <?php

                        }
                    ?>
                    <button class="btn btn-success px-5">Login</button>
                </div>
                <div class="form-group">
                    <p>Forgot password? <a href="#">Click here</a></p>
                </div>
                <div class="form-group">
                    <p>Don't Have an Account ?<a href="#">Create an account</a></p>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>
