<?php 

function db_connect() {
    
    $db_host = 'localhost';
    $db_user = 'mariusz888';
    $db_pass = 'mariusz888';
    $db_name = 'lidl';
    
    try {
        
        $db_connect = new mysqli("$db_host", "$db_user", "$db_pass", "$db_name");
        
    }
    catch (Exception $e) {
        
        throw new Exception("Błąd podczas połączenia z baza danych: " . $e->getMessage());
        
    }
    
}


?>