<?php
# ~ Tracey ~ 
# TITLE: Create New Project Script
# LOCATION: Server-side
# DESCRIPTION: Creates a new project record inside the database using the POSTed parameters (project name, type, leader ID etc.)
# NOTES: Keep in mind that foreign key constraints need to match for INSERTS into tables. i.e. The project leader ID passed 
# in as a parameter must already be an existing user in the user table.
#
#
#

#varchar
$projName = $_GET["name"];

#foreign key, bigint
$projType = $_GET["type"];

#foreign key, bigint
$projLeader = $_GET["lead"];


#auto-incrementing bigint
$projectId = "NULL";

#datetime
$today = getdate();
$creationDate = date( "Y-m-d H:i:s", $today );
echo $today;

#bigint
$projectStatus = 0;


#echo nl2br("- Project Info -\n");
#echo nl2br("Name: " . $projName . "\n");
#echo nl2br("Type: " . $projType . "\n");
#echo nl2br("Leader: " . $projLeader . "\n");

$query = "INSERT INTO `Armalit_tracey`.`Project` (`ProjectId`, `ProjectName`, `ProjectType`, `ProjectLeader`, `CreationDate`, `ProjectStatus`) 
VALUES (NULL, '" . $projName . "', '" . $projType . "', '" . $projLeader . "'," . $creationDate . ", 0);";

echo nl2br("Query: " . $query . "\n");

#mysql_query($query) or die(mysql_error());


?>

