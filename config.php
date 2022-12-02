<?php
// Database configuration 
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'workflow-db');
define('DB_HOST', 'us-cdbr-east-06.cleardb.net');
define('DB_USERNAME', 'b615ab0851539e');
define('DB_PASSWORD', 'd4d0cd63');
define('DB_NAME', 'heroku_768ef1d2fccdf85');

// Google API configuration
define('GOOGLE_CLIENT_ID', '415911045939-h6nj4ah1sjcmve0rh6140gr2m2m8112q.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive');
define('REDIRECT_URI', 'http://localhost:8888/workflow-application/gd-sync.php');
define('REDIRECT_URI', 'https://intense-peak-26854.herokuapp.com/gd-sync.php');

// Start session
if(!session_id()) session_start();

// Google OAuth URL
$googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online';

?>

