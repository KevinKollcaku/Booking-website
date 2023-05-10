<h1>Login</h1>
<style>
    input[type=submit] {
        background: linear-gradient(90deg, #05566a 0%, #29bdcb 50%, #05566a 100%);
        border: 0;
        border-radius: 5em;
        height: 2em;
        color: white;
        font-weight: bold;
        margin: 2em 0.5em 2em 0.5em;
    }
</style>

<form action="" method="POST">
    <?php
    require_once 'models/LoginModel.php';
    require_once 'core/FormField.php';
    /** @var $model LoginModel */
    $usernameField = new FormField($model, 'email');
    $passwordField = (new FormField($model, 'password'))->passwordField();
    echo $usernameField;
    echo $passwordField;
    ?>
    <div class="mb-3">
        <input type="submit" class="form-control" value="Login">
    </div>
</form>
