<?php

// DB Configs
include "config.php";
require_once "validate.php";

// Signup Function
function signUp($email_data, $password_data, $joinDate_data)
{
    if (!empty($email_data) && !empty($password_data) && !empty($joinDate_data)) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            return "db_connect_error";
        }

        $email = validate($email_data);
        $password = validate($password_data);
        $md5Pass = md5($password);
        $joinDate = validate($joinDate_data);
        $data = "failure";

        $log_sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($log_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = "registered";
        } else {
            $sql = "INSERT INTO users (password, email, joinDate) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $md5Pass, $email, $joinDate);
            if ($stmt->execute()) {
                $data = "success";
            }
        }

        $stmt->close();
        $conn->close();

        return $data;
    } else {
        return "null_data";
    }
}

// Login Function
function signIn($email_data, $password_data)
{
    if (!empty($email_data) && !empty($password_data)) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            return "db_connect_error";
        }

        $email = validate($email_data);
        $password = validate($password_data);
        $md5Pass = md5($password);
        $data = "email_not_exist";

        $log_sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($log_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $log_result = $stmt->get_result();

        if ($log_result->num_rows > 0) {
            $sql = "SELECT isUpdated FROM users WHERE email=? AND password=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $md5Pass);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['isUpdated'] > 0) {
                        $data = "success";
                    } else {
                        $data = "update";
                    }
                }
            } else {
                $data = "failure";
            }
        }

        $stmt->close();
        $conn->close();

        return $data;
    } else {
        return "null_data";
    }
}
?>