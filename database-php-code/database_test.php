<?php

// This code must go at the top of each page that uses database content

// your connection information goes here

$server_name = "[your server IP]"; // the IP address, which is the third item in the 34sp phpMyAdmin login form
$user_name = "[your db username]"; // the username you specified when you created the database
$password = "[your db password]"; // the password you specified when you created the database
$db_name = "[your db name]"; // the database name you specified when you created the database
$table_name ="[your db table name]"; // the table name you specified when you created the SQL in SQLizer

// STOP EDITING HERE: Upload this file to 34sp.com now

// Create connection
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// now we make some HTML

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database test page</title>
    <style>@import url('https://rsms.me/inter/inter.css');
html { font-family: 'Inter', sans-serif; }
@supports (font-variation-settings: normal) {
  html { font-family: 'Inter var', sans-serif; }
  body {max-width: 1000px; margin: 0 auto; padding: 3em 1em;}
h1 {font-size: 2em;}
h1 span {color:red;}
code {font-size: 1.1em; font-family:courier, monospace; color: #777;}
ul {margin: 0; padding:0; list-style-type:none;}
ul li {border-top:1px solid #ccc; padding-bottom: 2em;}
ul li h2 {font-size: 1em; margin:0; padding:0.3em 0;}
ul li code {font-size: 1em;}
ul li textarea {border:0; background: #eee; padding: 0.3em;}
ul li p {margin: 0;padding:0.3em 0; }
ul li p+p {border-top:1px solid #eee;}
}</style>

</head>
<body>

<?php 



$sql = "SELECT * FROM ".$table_name.";";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    echo "<h1>The script has successfully connected and is getting information from the <span>$table_name</span> table.</h1>";

    echo "<p>The sql query that has been run is <code>".$sql."</code>, which has resulted in the following fields being available for you to add to your site:</p><ul>";

    // output data of each row
    $i=1;
    while($row = mysqli_fetch_assoc($result)) {

        echo '<li><h2>Row '.$i.'</h2>';

        foreach($row as $name=>$r){

          echo '<p><code>&lt;?php echo $row[\''.$name.'\']; ?&gt;</code> will add <textarea class="content">'.$r.'</textarea> to your HTML</p>';
        }

  echo "</li>"; 
     $i++;
    }
    
} else {
    echo "<p>Sorry, something has gone wrong.</p>";
}

mysqli_close($conn);
?>
</ul>
</body>
</html>
