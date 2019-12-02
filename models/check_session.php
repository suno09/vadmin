<?php
function is_session_connected() {
    return (isset($_SESSION['session_username']) && $_SESSION['session_expire'] > time());
}
?>