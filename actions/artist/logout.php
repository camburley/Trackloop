<?php

// Authorization
Application::allow('artist, member');

// Clear and close session
$_SESSION = array();
session_destroy();

Application::redirect('/');