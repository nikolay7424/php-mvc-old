<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;

class Account extends Controller
{
    public function validateEmailAction()
    {
        //todo: fix the validation error (ignore_id doesn't work)
        $is_valid = ! User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);
        header("Content-type: application/json");
        echo json_encode($is_valid);
    }
}