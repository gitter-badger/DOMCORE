<?php
  // have to put this into a php block or the <?xml will be put as a PHP syntax error on extended code escape
  echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <!-- Generic browser family -->
  <title>DomCore Demos, a WebAbility&reg; Network Project</title>
  <meta http-equiv="PRAGMA" content="NO-CACHE" />
  <meta http-equiv="Expires" content="-1" />

  <meta name="Keywords" content="WAJAF, WebAbility" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="Charset" content="UTF-8" />
  <meta name="Language" content="en" />
  <link rel="stylesheet" href="/skins/css/domcore.css" type="text/css" />

</head>
<body>

<div class="container">

<a href="../index.html" class="back">&#xAB; Back to the index</a><br />
<br />

<h1>\datasources\DataSource example</h1>

<?php

// We assure any DomCore library we call will be automatically loaded
include_once '../include/__autoload.lib';

define('WADEBUG', false);
setlocale(LC_ALL, 'es_MX.UTF8', 'es_MX', '');
date_default_timezone_set('America/Mexico_City');

echo "We are testing this on:<br />";
echo "DomCore version ".\core\WADebug::VERSION."<br />";
echo "HTML API ? ".(\core\WADebug::getHTMLAPI()?'Yes':'No')."<br />";
echo "OS Type ? ".(\core\WADebug::getOSType()==\core\WADebug::WINDOWS?'Windows':(\core\WADebug::getOSType()==\core\WADebug::UNIX?'Unix':'Mac'))."<br />";
echo "<br />";

// Start the SHM with 20Mb default size and default ID
$SHM = new \core\WASHM();

// Lets create a LanguageSource based on the french messages
$Lang = new \datasources\LanguageSource(new \datasources\FileSource('./', '', 'message.es.xml'),
                           new \datasources\FastObjectSource(new \datasources\FileSource('./', '', 'temporal.afo'),
                                                new \datasources\SHMSource('spanish', $SHM)
                                               )
                           );

echo 'Show the full language table:<br />';

$data = $Lang->read();
foreach($data as $id => $val)
{
  echo "<b>$id</b>: $val<br />";
}
echo '<hr />';

echo 'Take the entry: WAFile.mkdirproblem<br />';
echo $data->getEntry('WAFile.mkdirproblem') . "<br />";
echo '<hr />';

echo 'Write a new entry: datasource.test (The original file, afo AND shared memory are synchronized)<br />';
$data->setEntry('datasource.test', 'Prueba de una nueva entrada de la tabla de idiomas') . "<br />";
$Lang->write($data);
echo '<hr />';

echo 'Show the entry: datasource.test<br />';
echo $data->getEntry('datasource.test') . "<br />";
echo '<hr />';

echo 'Deletes the entry: datasource.test<br />';
$data->delEntry('datasource.test') . "<br />";
$Lang->write($data);
echo '<hr />';

echo 'Show the full language table again, It is supposed to be the same as the first one:<br />';

foreach($data as $id => $val)
{
  echo "<b>$id</b>: $val<br />";
}
echo '<hr />';

?>

<br />
<br />
<br />
<br />

<a href="../index.html" class="back">&#xAB; Back to the index</a><br />

</div>

</body>
</html>
