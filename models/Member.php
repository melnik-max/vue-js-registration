<?php

namespace models;

use components\DB;
use core\Model;

class Member extends Model
{
    protected static $table = 'members';

    public static function isEmailInUse($email)
    {
        $db = DB::getConnection();
        $query = $db->prepare("SELECT * FROM members WHERE email = ? AND id != ?");
        $id = 0;
        if (!empty($_SESSION['member_id'])) {
            $id = $_SESSION['member_id'];
        }

        $query->execute([$email, $id]);

        return $query->rowCount() != 0;
    }
}