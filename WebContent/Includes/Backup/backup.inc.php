<?php
/*
<?php
$dbhost = 'localhost';
$dbuser = 'username';
$dbpassword = 'password';
$dbname = 'datenbankname';
$dumpfile = 'backups/' . $dbname . '_' . date("Y-m-d_H-i-s") . '.sql';
 
include_once('euer/pfad/zu/Mysqldump.php');
$dump = new Ifsnop\Mysqldump\Mysqldump("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
$dump->start($dumpfile);
*/


$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'project';
$dumpfile = 'backups/' . $dbname . '_' . date("Y-m-d_H-i-s") . '.sql';
//Speicherpfad 
include_once('C:\Users\Michael\Desktop\Mysqldump.php');
$dump = new Ifsnop\Mysqldump\Mysqldump("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
$dump->start($dumpfile);


//echo phpinfo();
/*
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<title>Page Title</title>';
echo '</head>';
echo '<body>';
echo '<button id="backup">BACKUP</button>'
echo 'phpinfo();' 
echo '<h1>This is a HeÄading</h1>';
echo '<p>This is a paragraph.</p>';

echo '</body>';
echo '</html>';
*/
?>