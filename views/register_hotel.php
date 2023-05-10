<h1>Register a Hotel</h1>


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

    $nameField = new FormField($model, 'Name');
    $descriptionField = new FormField($model, 'Description');
    $priceField = new FormField($model, 'Price');
    $Number_of_roomsField = new FormField($model,'Number_of_rooms');


    echo $nameField;
    echo $descriptionField;
    echo $priceField;
    echo $Number_of_roomsField;
    ?>

    <div class="mb-3">
        <input type="submit" class="form-control" value="Submit">
    </div>
</form>
