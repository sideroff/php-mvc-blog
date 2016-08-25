<?php

define('APP_ROOT' , '/blog');

//database connection string params
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASS', '');
define('DB_NAME', 'new_blog');


define('DEFAULT_HASH_ALGORITHM', 'sha256');
define('DEFAULT_AVATAR_PATH', APP_ROOT . '/content/avatars/default.png');

//form ids
define('FORM_USERNAME', 'username');
define('FORM_PASSWORD', 'password');
define('FORM_FIRST_NAME', 'first-name');
define('FORM_LAST_NAME', 'last-name');
define('FORM_EMAIL', 'email');
define('FORM_CONFIRM_PASSWORD', 'confirm-password');

//form field restrictions
define('USERNAME_MIN_LENGTH', 5);
define('USERNAME_MAX_LENGTH', 18);
define('PASSWORD_MIN_LENGTH', 6);
define('PASSWORD_MAX_LENGTH', 150);
define('PASSWORD_REGEX', '/(?=^.{' . PASSWORD_MIN_LENGTH .','.PASSWORD_MAX_LENGTH .'}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&;*()_+}{";:;\'?>;.<;,])(?!.*\s).*$/');
define('EMAIL_REGEX','/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,3})|(aero|coop|info|museum|name))$/');
define('EMAIL_MIN_LENGTH', 5);
define('EMAIL_MAX_LENGTH', 5);
define('FIRST_NAME_MIN_LENGTH', 2);
define('FIRST_NAME_MAX_LENGTH', 40);
define('LAST_NAME_MIN_LENGTH', 2);
define('LAST_NAME_MAX_LENGTH', 40);

?>