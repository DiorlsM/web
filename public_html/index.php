<?php
/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '1');

/**
 * Defined path core
 */
define('BASEPATH', '../libs/');

/**
 * Core System
 */
require_once BASEPATH . 'core.php';
