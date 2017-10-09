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
            
            echo czas_przepracowanego_dnia() . '<br>';
            echo przerwa_netto() . '<br>';
            
        } else {
            
            echo '<h2 class="alert alert-danger">Prosze wypłenić wszystkie Pola.</h2>';
            
        }
        
    }
    
}


/**
 * Funkcja zliczająca całkowity czas przerwy
 * @return [[time]] [[Zwraca czas przerwy w minutach]]
 */
function licz_przerwe() {
    
    if($_GET['czas_rozp_prz'] && $_GET['czas_kon_prz']) {
        
        $pczk_prz = $_GET['czas_rozp_prz'];
        $kon_prz = $_GET['czas_kon_prz'];
        
        $przerwa = strtotime($kon_prz) - strtotime($pczk_prz);
        
        return $przerwa;
        
    }
    
}


/**
 * funkcja odejmująca 15 min płatnej przerwy
 * od jej całkowitego czasu
 * @return [[zwraca czas netto przerwy]] 
 */
function przerwa_netto() {
    
    $przerwa_unix = 15 * 60;
    $prz_netto = licz_przerwe() - $przerwa_unix;
    
    return $prz_netto;
    
}


/**
 * Suma całkowita godzin netto pracy
 * @return [[zwraca przepracowany dzien w godzinach]]
 */
function czas_przepracowanego_dnia() {
    
    if( isset($_GET['rozpoczecie_pracy']) && isset($_GET['koniec_pracy']) ) {
        
        $poczatek_pracy = $_GET['rozpoczecie_pracy'];
        $koniec_pracy = $_GET['koniec_pracy'];
        
        $czas_pracy_brutto = strtotime($koniec_pracy) - strtotime($poczatek_pracy) - przerwa_netto();
        $czas_pracy_netto = $czas_pracy_brutto  / 60;
        $czas_pracy_modulo = $czas_pracy_netto % 60;
        $czas_pracy_modulo = czas_pracy_modulo($czas_pracy_modulo);
        $czas_pracy_netto = $czas_pracy_netto / 60;
        $czas_pracy_netto = (int)$czas_pracy_netto;
        $wynik = $czas_pracy_netto . "." . $czas_pracy_modulo;
    }
    
    return $wynik ;
    
}


/**
 * Funkcja służąca do poprawnego wyświetlania minut po przecinku
 */
function czas_pracy_modulo($czas_pracy_modulo) {
    
    if($czas_pracy_modulo <= 9) {
        
        $czas_pracy_modulo = 0.0 . $czas_pracy_modulo;
        
    } elseif ($czas_pracy_modulo == 1) {
        
        $czas_pracy_modulo = round($czas_pracy_modulo);
        
    }
    
    return $czas_pracy_modulo;
    
}

?>