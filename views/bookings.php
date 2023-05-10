
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

<br/>
<br/>
<br/>

<h2>List of Bookings that  <?php Application::$APP->getUser()?->getDisplayName() ?? "_" ?> has made</h2>
<ul>
<?php


//printing all the hotels
if(is_null($Bookings)){
    echo "<p>No Booking has been made</p>";
}else{

foreach ($Bookings as $b) {
    echo "<div style='border-style: solid; margin-top: 2rem; background-color: rgba(255, 255, 255, 0.5);'>";

    echo "
    <label>ID of the hotel:</label>{$b['Hotel_ID']}<br>
    
    <label>Number of days:</label>{$b['Number_of_days']}<br>
    

    <label>Number of people:</label>{$b['Number_of_days']}<br>
    ";
    

echo "</div>";
}
}
?>
</ul>
