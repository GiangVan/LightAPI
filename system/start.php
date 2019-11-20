<?php

require_once('autoload.php');

RouteHandler::start(new FormattedURI($_SERVER['REQUEST_URI']));