# PHP for Applied Web Design and Development

## Includes

Includes are a way of re-using HTML and making it easier to make 'global' changes to your website, e.g. adding or removing items from your header, navigation or footer.

To use includes, you will need to install a 'local' webserver like [MAMP](https://www.mamp.info/en/) for Mac or [XAMPP](https://www.apachefriends.org/index.html) for PC, and move your prototype website into the `htdocs` folder of your local webserver. Make sure the webserver is running when you try and preview your site.

### The process

* Identify parts of your HTML that are the same between pages, or very similar
* Create a `includes` folder for your site
* Cut and paste these parts out of your prototype HTML pages into new files. Save these new files with a `.php` extension, e.g. `header.php`.
* Replace the cut-out section of your HTML code with this line of PHP: `<?php include('includes/header.php'); ?>
* View the code and you will see the HTML include added to the HTML of your website.
* You can also add a variable like the title of your HTML page, like this:
```
<?php

$page_title = "Bars and Clubs";
include('includes/header.php); 
?>
```

then the included `header.php` will need a line like this in the HTML:

```
<html>
<head>
<title><?php echo $page_title; ?> | Manchester guide to bars and clubs</title>
</head>
```

The output HTML will be:

```
<html>
<head>
<title>Bars and Clubs | Manchester guide to bars and clubs</title>
</head>
```

## Adding database content to your website

### The process

#### Create the HTML and CSS prototype

First, create a prototype version of your website's category page and detail page. So if you are working on a website of Manchester buildings, create the HTML page that lists the buildings (the category page), style the HTML with CSS, and add one or two examples of what the listing part of the page would look like, e.g.

```
<h2>Interesting buildings of Manchester</h2>
<ul>
<li><a href="detail.html">Interesting building 1</a></li>
<li><a href="detail.html">Interesting building 2</a></li>
</ul>
```

Do the same thing for the detail page, which is the content about a single building in this case (or bar, or club, etc):

```
<h1>Building Name</h1>
<img src="building-image.jpg" alt="Building Name image" />
<div class="building-description>
<p>Content about the building</p>
</div>
<ul>
<li>Building data</li>
<li>Building data</li>
<li>Building data</li>
<li>Building data</li>
</ul>
```

Again, style this up with CSS and get the page working responsively. At this point your group should look at your content and check that your design works with all the data you have collected.

#### Add your content to a database

##### Create a database

First, we have to [create a database in your 34sp control panel](https://account.34sp.com/).

* Log on to the control panel, click 'Manage Websites', then 'Settings'.
* Unlock your FTP
* Click on 'databases' in the top menu bar
* Click the green 'add new database' button
* Enter a database name, username and password. **Write these down as you will need them later**.
* Once you have created the database, find it in the list of databases and click the **PHPMyAdmin** button (why this is next to **remove database** I have no idea)
* You will get a page with three boxes. The first is your database username, the second the database password, and the third, which is autofilled, is the database server address, which will look something like `46.183.13.53`. **Write down the database server address as you will need it later**.
* You should then be able to view the (frankly ugly) PHPMyAdmin control panel.

##### Convert your excel file to MySQL

* Ensure the first row of your excel spreadsheet contains the names of your data fields, e.g. `building-name`, `building-date`, etc. These should all be without spaces and lower case
* Save the latest version of your Excel file (but keep it open)
* [Go to SQLizer.io](https://sqlizer.io/)
* Select your excel file, leave all the checked items checked on the SQLizer form. For **worksheet name**, either use `Sheet1` or the name of the worksheet with your content in it. For **cell range**, use the default of `A1:AA256`. For **Database Table Name** use a sensible name with no spaces (use underscores or dashes for separators). **Write down the table name as you will need it later**.
* For all of the fields in the SQLizer page, you need to type in actual values, even if it's just typing the same thing over the grey placeholder text (interesting UX choice there).
* Click `convert my file` and the system will work away. 
* You should then see a form field with some SQL in it. Select all the code in this form field and copy it to the clipboard (`ctrl-a` or `command-a` to select all, then `ctrl-c` or `command-c` to copy)

##### Get the content into your database

* Swop back to 34sp and the PHPMyAdmin control panel
* click on the name of your database on the left hand side panel
* click on 'SQL' in the top nav
* Paste (`ctrl-v` or `command-v`) the SQL from SQLizer into the large box under the **Run SQL query heading**
* Then click **go**
* If all goes well the content will be added to the database
* Now click the 'structure' tab
* Click on the name of the new table that's just been added and hopefully you will see your excel data imported into your database!
* That's more or less it, but we still need to add a numerical ID to this table so our query string will work
* On the structure tab, look under your database content for the `Add [ ] column(s)` form. Change the dropdown so it says `at the beginning of table` and click **go**.
* On the form that appears, in `name` type `id`, for the `index` dropdown change this to `primary` (and click OK in the form that appears) and then tick the `A_I` checkbox. Then under the form click the **save** button.
* You will now go back to the 'browse' tab and there should be an `id` field added to the start of your table which will have automatically numbered each item in your table.
* That's really it!

#### Get PHP talking to your database

We are now going to create a file and upload it to your webspace, which will act as the starting point for you to cut and paste what you need into the template HTML pages you have created.

[The code you need is saved as a separate page in this repository](https://github.com/mmu-webdesign/level5-portfolio/blob/master/PHP-code/database_test.php). Click 'raw' in the top nav to just get the code to cut and paste. You will need a working database, the username, password, server address, database name and database table name to make this file work correctly.

Add the relevant details to your own version of the file in the repository, save the updated file as `database_test.php` and save it to the `httpdocs` folder of 34sp.

Then go to `http://[your mmu id].webdevmmmu.uk/database_test.php` and you will hopefully see it working.

The file gives you information about how to get access to each field in your database table.

#### Add the relevant PHP to your template HTML pages

To get this working, we:

* Connect to the database
* Run an SQL query
* Create a loop
* Add the relevant content in the correct places in the HTML

##### Connecting to the database

Use this snippet of code from the `database_test.php` file:

```
<?php

// This code must go at the top of each page that uses database content

// your connection information goes here

$server_name = "[IP address]"; // the IP address, which is the third item in the 34sp phpMyAdmin login form
$user_name = "[user name]"; // the username you specified when you created the database
$password = "[password]"; // the password you specified when you created the database
$db_name = "[database name]"; // the database name you specified when you created the database
$table_name ="[table name]"; // the table name you specified when you created the SQL in SQLizer

// Create connection
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// now we make some HTML

?>
```

##### Querying the database

Use this snippet of code from the `database_test.php` file for the category page:

```
<?php 

// To get all the information from the database

$sql = "SELECT * FROM ".$table_name.";";

$result = mysqli_query($conn, $sql);

?>
```

For your detail page, use something like:

```
<?php 

// To get all the information from the database

$sql = "SELECT * FROM ".$table_name." where id=".$_GET['id'].";"; // This is an unsafe way of doing this because we are not checking that the content is only a number

$result = mysqli_query($conn, $sql);

?>
```

##### Getting to the point where we can put something on the page

Use code like this:

```

if (mysqli_num_rows($result) > 0) {

    
    while($row = mysqli_fetch_assoc($result)) {
// At this point your content will be in the $row[] array, so access it something like this:

echo $row['my-field-name']; // see the examples from database_test.php

// this is also where you would put the hyperlink code below

    }

} else {
    echo 'something went wrong';
}

```

##### Linking from the category page to the detail page

Use code similar to this on your category page:

```
<a href="detail.php?id=<?php echo $row['id']; ?>">
[Your Link text or markup]
</a>
```
