<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Verdana, Geneva, sans-serif;
        }

        h2 {
            color: #444;
        }

        p.ok {
            color: green;
        }

        p.fail {
            color: red;
        }
    </style>
</head>
<body>
<?php

function result($value, $result)
{
    if ($result) {
        return '<p class="ok">' . $value . ': OK</p>';
    }
    return '<p class="fail">' . $value . ': FAIL</p>';
}

echo '<h2>Apache</h2>';
echo '<p>Version: ' . apache_get_version() . '</p>';
$requiredModules = array('mod_rewrite');
$apacheModules = apache_get_modules();
foreach ($requiredModules as $req) {
    echo result($req, in_array($req, $apacheModules));
}

echo '<h2>PHP</h2>';
echo '<p>Version: ' . phpversion() . '</p>';
$requiredExtensions = array(
    'curl',
    'gd',
    'intl',
    'mbstring',
    'mcrypt',
    'openssl',
    'PDO',
    'SimpleXML',
    'soap',
    'xml',
    'xsl',
    'zip',
    'json',
    'iconv',
    'Zend OPcache',
    'xdebug',
);
$phpExtensions = get_loaded_extensions();
foreach ($requiredExtensions as $req) {
    echo result($req, in_array($req, $phpExtensions));
}
?>
</body>
</html>
