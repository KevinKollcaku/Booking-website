
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

<h2>List of Hotels</h2>
<ul>
<?php


//printing all the hotels
foreach ($hotels as $hotel) {
    echo "<div style='border: 1px solid white; margin-top: 2rem; padding: 0.5rem; background-color: rgba(255, 255, 255, 0.5);'>";

    //echo "<form method=\"POST\">";

    // <input type=\"text\" id=\"{$hotel['Name']}\" name=\"Name\"  value=\"{$hotel['Name']}\" readonly><br>
    // <input type=\"text\" id=\"{$hotel['Description']}\" name=\"Description\"  value=\"{$hotel['Description']}\" readonly><br>
    // <input type=\"text\" id=\"{$hotel['Price']}\" name=\"Price\"  value=\"{$hotel['Price']}\" readonly><br>
    
    // <input type=\"text\" id=\"{$hotel['Number_of_rooms']}\" name=\"Number_of_rooms\"  value=\"{$hotel['Number_of_rooms']}\" readonly><br>


    echo "
    <form method=\"POST\" action=\"/book\">
    <label for=\"Hotel_ID\">Hotel for booking</label><br>
    <input type=\"hidden\" id=\"{$hotel['Hotel_ID']}\" name=\"Hotel_ID\"  value=\"{$hotel['Hotel_ID']}\" readonly><br>
    
    <label> Name of the hotel: </label> {$hotel['Name']} <br>
    <label> Description: </label><br>
    {$hotel['Description']}<br>
    <label> Price per person: </label>
    {$hotel['Price']}<br>
    <lable> Number of rooms that this hotel has</label>
    {$hotel['Number_of_rooms']}<br>

    <label for=\"days\">Number of days:</label>
    <input type=\"number\" name=\"Number_of_days\" id=\"days\" required>
    <br>
    <label for=\"people\">Number of people:</label>

    
    <input type=\"number\" name=\"Number_of_People\" id=\"people\" required>
    <br>
    <label for=\"startdate\">Starting date:</label>
    <input type=\"date\" name=\"Start_date\" id=\"startdate\" required>
    <br>
    
    <input type=\"submit\" class=\"form-control\" value=\"Submit\">
    </form>";
    
    //echo "</form>";
    //echo "<p>Finished one of this</p>";
    // echo "<p>Hotel ID: {$hotel['Hotel_ID']}</p>";
    // echo "<p>Hotel Name: {$hotel['Name']}</p>";
    // echo "<p>Hotel Address: {$hotel['Description']}</p>";
    // echo "<p>Hotel City: {$hotel['Number_of_rooms']}</p>";
    // echo "<p>Hotel Country: {$hotel['Price']}</p>";
    // echo "<div class=\"mb-3\">

echo "</div>";
}
?>
</ul>

