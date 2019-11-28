<?php 
include_once('database.model.php');

if (isset($_POST['new_username'])) {
    $result = Database::execute_query_with_prepared_statement(
		"select * from users where username = lower(?) and active=?;",
        array($_POST['new_username'], 1));
        
    // user name exist
    $response;
    if ($result->num_rows !== 0) {
        $response = array("type"=> "0", "message"=> "Nom d'utilisateur existe !"); // error username existe
    } else {
        Database::execute_query_with_prepared_statement(
            "insert into users (username, password, type) values (lower(?), password(?), ?);", 
            array($_POST['new_username'], md5($_POST['new_password']), $_POST['new_role']));
        $response = array("type"=> "1", "message"=> "Opération terminée avec succès !"); // success
    }

    echo json_encode($response, JSON_FORCE_OBJECT);
}
?>