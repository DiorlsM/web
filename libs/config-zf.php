<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

set_include_path(
    '.' . PATH_SEPARATOR . realpath(dirname(__FILE__))
    .PATH_SEPARATOR . get_include_path()
);

require 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();