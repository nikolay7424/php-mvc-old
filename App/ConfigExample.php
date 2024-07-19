<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class ConfigExapmle
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mvclogin';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'mvcuser';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '123456';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;


    //use your mailgun api keys
    const SECRET_KEY = '';

    const MAILGUN_API_KEY = '';

    const MAILGUN_DOMAIN = '';
}

