<h1>Register</h1>


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

<?php
require_once 'models/User.php';
require_once 'core/FormField.php';

/** @var $model User */ ?>

<form action="" method="POST">
    <?php

    //model is defined in the calling class it is $user mode in this case
    $firstNameField = new FormField($model, 'firstName');

    $lastNameField = new FormField($model, 'lastName');

    $emailField = new FormField($model, 'email');
    //immidiately treating the passwod field more carefully
    //we just cahnge the type from text to password

    $passwordField = (new FormField($model, 'password'))->passwordField();
    
    $username = new FormField($model,'username');

    $access_level = new FormField($model, 'access_level');

    $Telephone_Number = new FormField($model, 'Telephone_Number');
    
    $Date_Created = new FormField($model,'Date_Created');

    echo $firstNameField;
    echo $lastNameField;
    echo $emailField;
    echo $passwordField;
    echo $username;
    echo $access_level;
    echo $Telephone_Number;
    echo $Date_Created;

    ?>

    <div class="mb-3">
        <input type="submit" class="form-control" value="Submit">
    </div>
</form>
