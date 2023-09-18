<?php require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check(
            $_POST,
            array(
                'password_current' => array(
                    'required' => true,
                    'min' => 6,
                ),
                'password_new' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_new_again' => array(
                    'required' => true,
                    'min' => 6,
                    'matches' => 'password_new'
                )
            )
        );
        if($validation->passed())
        {
            //Change of Password
            if(Hash::make(Input::get('password_current'),  $user->data()->salt) !== $user->data()->password()) 
            {
                echo 'Incorrect Password';
            } else {
                //Update Password
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));
                Session::flash('home', 'Password Updated Successfully!');
                Redirect::to('index.php');
            }
        } else {
            foreach($validation->errors() as $error)
            {
                echo $error, '<br>';
            }
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Change Password</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <?php

    ?>

    <form action="" method="post" class="text-center p-5">
        <div class="field">
            <label for="password_current">Current Password</label>
            <input type="text" name="password_current" id="password_current" ?>">
        </div>

        <div class="field">
            <label for="password_new">New Password</label>
            <input type="text" name="password_new" id="password_new" ?>">
        </div>

        <div class="field">
            <label for="password_new_again">Repeat Password</label>
            <input type="text" name="password_new_again" id="password_new_again">
        </div>

        <input type="submit" value="Change">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </form>

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