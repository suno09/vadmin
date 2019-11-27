<?php 
if (isset($_POST['new_username'])) {
    $result = Database::execute_query_with_prepared_statement(
		"select * from users where username = lower(?) and active=?;",
        array($_POST['new_username'], 1));
        
    // user name exist
    if ($result->num_rows !== 0) {
        $response->type = "0"; // error username existe
        $result->message = "Nom d'utilisateur existe !";

        echo json_encode($response);
    } else {
        $response->type = "1"; // success
        $result->message = "Opération terminée avec succès";
    }
}
?>