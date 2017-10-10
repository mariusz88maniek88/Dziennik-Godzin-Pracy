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
            case 'edit' :
                include 'form_edit.php';
                break;
            case 'delete' :
                include 'delete.php';
                break;
                                
        } 
        
    }
    
}


function delete_day_hours() {
    
    if(isset($_GET['tak_delete'])) {
    
        @$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
                $query = "DELETE * FROM users WHERE id=" . $row['id'] ;
                
                if( @$db_connect->query($query) ) {
                    
                    header("Location:index.php");
                    exit;
                    
                }
    
    } else {
    
        header("Location:index.php");
        exit;
    
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
            
            $date = htmlspecialchars($date);
            $poczatek_pracy = htmlspecialchars($poczatek_pracy);
            $koniec_pracy = htmlspecialchars($koniec_pracy);
            $poczatek_przerwy = htmlspecialchars($koniec_przerwy);
            $koniec_przerwy = htmlspecialchars($koniec_przerwy);
            
            $query = "INSERT INTO czas VALUES(null, '$date', '$poczatek_pracy', '$koniec_pracy', '$poczatek_przerwy', '$koniec_przerwy'," . licz_przerwe_min() . "," . przerwa_netto_min() . "," . czas_przepracowanego_dnia() . ")";
            
            @$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if( @$db_connect->query($query)){
                
                echo 'Godziny zostały zapisane';
                
            } else {
                
                echo "<h2 class='alert alert-danger'>Wystapił błąd podczas zapisywania.</h2>";
                
            }
            $db_connect->close();
            
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
 * Funkcja zliczająca całkowity czas przerwy
 * @return [[time]] [[Zwraca czas przerwy w minutach]]
 */
function licz_przerwe_min() {
    
    $przerwa_cal = licz_przerwe() / 60;
    $przerwa_cal = htmlspecialchars($przerwa_cal);
    
    return $przerwa_cal;
    
}


/**
 * funkcja odejmująca 15 min płatnej przerwy
 * od jej całkowitego czasu do wyliczen( unix)
 * @return [[zwraca czas netto przerwy]] 
 */
function przerwa_netto() {
    
    $przerwa_unix = 15 * 60;
    $prz_netto = licz_przerwe() - $przerwa_unix;
    
    return $prz_netto;
    
}

/**
 * funkcja odejmująca 15 min płatnej przerwy
 * od jej całkowitego czasu do zapisu w bazie ( min)
 * @return [[zwraca czas netto przerwy]] 
 */
function przerwa_netto_min() {
    
    $przerwa_fin = przerwa_netto() / 60;
    
    return $przerwa_fin;
    
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
        
    } elseif ($czas_pracy_modulo ) {
        
        $czas_pracy_modulo = round($czas_pracy_modulo);
        
    }
    
    return $czas_pracy_modulo;
    
}


function show_table_hours() {
    
    @$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if( !@$db_connect->connect_errno ) {
        
        $query = "SELECT * FROM czas";
        
        if( $result = @$db_connect->query($query)  ) {
            ?>
            
            <table class="table table-hover">
                <tr>
                    <th>Data</th>
                    <th>Cz.Rozp.</th>
                    <th>Cz.Zako.</th>
                    <th>Roz.Przer.</th>
                    <th>Zak.Przer.</th>
                    <th>Przerwa</th>
                    <th>Przerwa(-15min)</th>
                    <th>SUMA</th>
                    <th></th>
                    <th></th>
                </tr>
            
            <?php
            
            while( $row_table = $result->fetch_assoc() ) {
                
                echo '<tr>';
                echo '<td>' . $row_table['date'] . '</td>';
                echo '<td>' . $row_table['poczatek_pracy'] . '</td>';
                echo '<td>' . $row_table['koniec_pracy'] . '</td>';
                echo '<td>' . $row_table['poczatek_przerwy'] . '</td>';
                echo '<td>' . $row_table['koniec_przerwy'] . '</td>';
                echo '<td>' . $row_table['przerwa_cala'] . '</td>';
                echo '<td>' . $row_table['przerwa_15minut'] . '</td>';
                echo '<td>' . $row_table['suma_godz'] . '</td>';
                echo '<td><a href="index.php?action=wybor&wybor=edit&id=' . $row_table['id'] . '">Edytuj</td>';
                echo '<td><a href="index.php?action=wybor&wybor=delete&id=' . $row_table['id'] . '">Usuń</td>';
                
            }
          
            echo '</table>';
            
            
        }
        
    } else {
        
        echo 'Wystąpił błąd podczas połączenia z serwerem.';
        
    }
    
}



?>