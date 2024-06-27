<?php

namespace App\Controllers;

use App\Models\User;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    public function createAction()
    {
        $user = new User($_POST);
        if ($user->save()) {
            $this->redirect("/signup/success");
        } else {
            View::renderTemplate('Signup/new.html', ["user" => $user]);
        }
    }

    public function successAction()
    {
        View::renderTemplate('Signup/success.html');
    }
}
