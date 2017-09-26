<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function result($value, $result)
{
    if ($result) {
        return array('css' => 'success', 'note' => $value . ': OK');
    }
    return array('css' => 'danger', 'note' => $value . ': FAIL');
}

function apacheModules()
{
    $results = array();
    preg_match('/([\d]+\.[\d]+\.[\d]+)/', apache_get_version(), $version);
    $results[0] = array('css' => 'danger', 'note' => 'Version: ' . $version[0]);
    if (version_compare($version[0], '2.2') >= 0) {
        $results[0] = array('css' => 'success', 'note' => 'Version: ' . $version[0]);
    }
    $requiredModules = array('mod_rewrite','mod_expires');
    $apacheModules = apache_get_modules();
    foreach ($requiredModules as $req) {
        $results[] = result($req, in_array($req, $apacheModules));
    }
    return $results;
}

function phpExtensions()
{
    $results = array();
    preg_match('/([\d]+\.[\d]+\.[\d]+)/', phpversion(), $version);
    $ver = $version[0];
    $results[0] = array('css' => 'danger', 'note' => 'Version: ' . $ver);
    if ((version_compare($ver, '5.6.5', '>=') && version_compare($ver, '7.0.0', '<')) || version_compare($ver, '7.0.2',
            '==') || version_compare($ver, '7.0.4', '==') || version_compare($ver, '7.0.6', '>=')
    ) {
        $results[0] = array('css' => 'success', 'note' => 'Version: ' . $ver);
    }
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
        $results[] = result($req, in_array($req, $phpExtensions));
    }
    return $results;
}

function phpOptionalExtensions()
{
    $optionalExtensions = array(
        'imagick',
    );
    $phpExtensions = get_loaded_extensions();
    $results = array();
    foreach ($optionalExtensions as $opt) {
        $results[] = result($opt, in_array($opt, $phpExtensions));
    }
    return $results;
}
//apacheModules();
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>Magento 2 requirements check script</h1>
    <div class="panel panel-default">
        <div class="panel-heading">Apache</div>
        <div class="panel-body">
            <?php foreach (apacheModules() as $result): ?>
                <div class="alert alert-<?php echo $result['css'] ?>" role="alert"><?php echo $result['note'] ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">PHP</div>
        <div class="panel-body">
            <div role="alert" class="alert alert-warning">Loaded php.ini file: <?php echo php_ini_loaded_file()?></div>
            <?php foreach (phpExtensions() as $result): ?>
                <div class="alert alert-<?php echo $result['css'] ?>" role="alert"><?php echo $result['note'] ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Optional PHP Extension</div>
        <div class="panel-body">
            <?php foreach (phpOptionalExtensions() as $result): ?>
                <div class="alert alert-<?php echo $result['css'] ?>" role="alert"><?php echo $result['note'] ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
