<?php

require_once 'config/const.php';
require_once 'connect.php';

try {
    $connect = connect(PATH_CONF);
} catch (PDOException $exception) {
    print $exception->getMessage();
}

$entityName = $_POST['entity'] ?? '';
$id = $_POST['id'] ?? '';

$resp = ['error'];

if ($entityName) {
    if ($id) {
        $query = 'SELECT * FROM ' . $entityName . ' WHERE `id` = :id';
        $params = [
            ':id' => $id
        ];
        $stmt = $connect->prepare($query);
        try {
            $stmt->execute($params);
        } catch (PDOException $exception) {
            //
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            $resp = $rows;
        }
    } else {
        $query = 'SELECT * FROM '  . $entityName;
        $stmt = $connect->prepare($query);
        try {
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                $resp = $rows;
            }
        } catch (PDOException $exception) {
            //
        }
    }
}
print json_encode($resp);
