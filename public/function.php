<?php 

/**
 * Funkcja wyświetlająca wybór formularza
 * na stronie indeksu
 */
function show_from() {
    
    if(isset($_GET['wybor'])  ) {
        
        switch($_GET['wybor']) {
            case 'urlop':
                include 'urlop.php';
                break;
            case 'godziny' :
                include 'form.php';
                break;
                                
        } 
        
    }
    
}

/**
 * Zapisywanie czasu pracy do bazy
 */
function save_hours() {
    
    if (isset($_GET['zapisz_godziny'])) {
        
        $date = $_GET['data'];
        $poczatek_pracy = $_GET['rozpoczecie_pracy'];
        $koniec_pracy = $_GET['koniec_pracy'];
        $poczatek_przerwy = $_GET['czas_rozp_prz'];
        $koniec_przerwy = $_GET['czas_kon_prz'];
        
        if( !empty($date) && !empty($poczatek_pracy) && !empty($koniec_pracy) && !empty($poczatek_przerwy) && !empty($koniec_przerwy) ) {
            
            echo licz_przerwe();
            
        } else {
            
            echo '<h2>Wypełnij pola</h2>';
            
        }
        
    }
    
}


function licz_przerwe() {
    
    if($_GET['czas_rozp_prz'] && $_GET['czas_kon_prz']) {
        
        $pczk_prz = $_GET['czas_rozp_prz'];
        $kon_prz = $_GET['czas_kon_prz'];
        
        $przerwa = strtotime($kon_prz) - strtotime($pczk_prz);
        $przerwa = $przerwa / 60;
        
        return $przerwa;
        
    }
    
}



?>