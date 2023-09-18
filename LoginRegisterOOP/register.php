<?php require_once 'core/init.php';


if (Input::exists()) {
    if (Token::check(Input::get('token'))) {



        $validate = new Validate();
        $validation = $validate->check(
            $_POST,
            array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),

                'password' => array(
                    'required' => true,
                    'min' => 6,
                    'max' => 8,
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                ),
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                )
            )
        );
        if ($validation->passed()) {
            $user = new User();

            $salt = Hash::salt(32);


            try {
                $user->create(
                    array(
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'name' => Input::get('name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => 1
                    )
                );
                //Register User 
                Session::flash('home', 'Registration Successful!');
                Redirect::to(404);
            } catch (Exception $e) {
                die($e->getMessage());
            }

        } else {
            //Output Validation Error
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Login & Register Form OOP PHP</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>



    <?php require_once 'includes/header.php'; ?>



    <div class="p-3 text-center">
        <h3 class="text-center text-dark">Register</h3>
        <form action="" method="post" class="form-floating outline-none">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>"
                    autocomplete="off">
            </div>

            <div class="field">
                <label for="username">Password</label>
                <input type="password" name="password" id="password" value="" class="rounded-5">
            </div>
            <div class="field">
                <label for="password_again">Repeat Password</label>
                <input type="password" name="password_again" id="password_again" value="" class="rounded-5">
            </div>

            <div class="field">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>"
                    class="rounded-5">
            </div>

            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" value="Register" class="btn btn-success">
        </form>
    </div>



    <?php require_once 'includes/footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>