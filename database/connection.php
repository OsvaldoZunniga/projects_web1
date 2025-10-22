<?php
    function getConnection_BD() {
        $server = "localhost";
        $username = "root";
        $password = "";
        $dbname = "subiteyreza";

        $connection = new mysqli($server, $username, $password, $dbname);

        if ($connection->connect_error) {
        die("Connection Failed: " . $connection->connect_error);
        }

        return $connection;
    }
?>
