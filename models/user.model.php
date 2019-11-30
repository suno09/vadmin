<?php
include_once('database.model.php');
// include_once('check_session.php');

// if(!is_session_connected()) {
//     $response = array("type" => "-1", "message" => "La session a expiré !"); // session expire
//     echo json_encode($response, JSON_FORCE_OBJECT);
// } else 
switch ($_POST['action']) {
    case 'insert':
        $result = Database::execute_query_with_prepared_statement(
            "select * from users where username = lower(?) and active=?;",
            array($_POST['username'], 1)
        );

        // user name exist
        $response;
        if ($result->num_rows !== 0) {
            $response = array("type" => "0", "message" => "Nom d'utilisateur existe !"); // error username existe
        } else {
            Database::execute_query_with_prepared_statement(
                "insert into users (username, password, role) values (lower(?), password(?), ?);",
                array($_POST['username'], md5($_POST['password']), $_POST['role'])
            );
            $response = array("type" => "1", "message" => "Opération terminée avec succès !"); // success
        }

        echo json_encode($response, JSON_FORCE_OBJECT);
        break;
    case 'get_by_id':
        $response;
        $result = Database::execute_query_with_prepared_statement(
            "select * from users where id_user = ? and active=?;",
            array($_POST['id_user'], 1)
        );

        if ($row = $result->fetch_assoc()) {
            $response = json_encode($row, JSON_FORCE_OBJECT);
        } else {
            $response = "{'id_user': 0}";
        }

        echo $response;
        break;
    case 'update':
        $result = Database::execute_query_with_prepared_statement(
            "select 1 from users where id_user <> ? and username = lower(?) and active=?;",
            array($_POST['id_user'], $_POST['username'], 1)
        );

        // user name exist
        $response;
        if ($result->num_rows !== 0) {
            $response = array("type" => "0", "message" => "Nom d'utilisateur existe !"); // error username existe
        } else {
            Database::execute_query_with_prepared_statement(
                "update users set username = lower(?), role = ? where id_user = ?;",
                array($_POST['username'], $_POST['role'], $_POST['id_user'])
            );
            $response = array("type" => "1", "message" => "Opération terminée avec succès !"); // success
        }

        echo json_encode($response, JSON_FORCE_OBJECT);
        break;
    case 'update_pass':
        Database::execute_query_with_prepared_statement(
            "update users set password = password(?) where id_user = ?;",
            array(md5($_POST['new_password1']), $_POST['id_user'])
        );
        $response = array("type" => "1", "message" => "Opération terminée avec succès !"); // success
        echo json_encode($response, JSON_FORCE_OBJECT);
        break;
}
?>
