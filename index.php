<?php

namespace GeditLab\Web;

/**
 * @file index.php
 *
 * @brief The main entry point to the application.
 */

require_once('GeditLab/Web/WebServer.php');

$server = new WebServer();
$server->run();

