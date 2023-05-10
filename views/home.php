<?php
// echo "Home page of application $name <br>";

if (Application::$APP->isAuthenticated()) {
    $displayName = Application::$APP->getUser()?->getDisplayName() ?? "User";
    echo "<br/><br/><br/><p style:'font-size: larger;'>Welcome $displayName!</p><br>";
} else {
    echo <<< EOF
    <style>
        p {
            font-size: larger;
        }
        a {
            text-decoration: none;
            color: #29bdcb;
        }
    </style>

    <br/>
    <br/>
    <br/>
    <p>Not authenticated</p>
    <p><a href="/login">Log in</a> if you wish to view our hotels and book rooms to stay!</p>
    EOF;
}


