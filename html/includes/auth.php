<?php

/**
* Register a user
*
* @param array $user_data
* @param bool $is_admin
* @return bool
*/
function register_user(array $user_data, bool $is_admin = false): bool
{
    // TODO Update the registration database.
//    $sql = 'INSERT INTO users(username, email, password, is_admin)
//            VALUES(:username, :email, :password, :is_admin)';
//
//    $statement = db()->prepare($sql);
//
//    $statement->bindValue(':username', $username, PDO::PARAM_STR);
//    $statement->bindValue(':email', $email, PDO::PARAM_STR);
//    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
//    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);
//
//    return $statement->execute();
    return true;
}