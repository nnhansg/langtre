<?php
require_once 'lib/php-activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_model_directory(getcwd() . '\models');
    $cfg->set_connections(array(
        'development' => 'mysql://root:hongnhan@localhost/bookinglangtre_bldr'
    ));
});