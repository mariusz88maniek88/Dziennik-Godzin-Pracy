<?php 
ob_start();
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
    
    global $db_connect;
    
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
            $poczatek_przerwy = htmlspecialchars($poczatek_przerwy);
            $koniec_przerwy = htmlspecialchars($koniec_przerwy);
            
            $query = "INSERT INTO czas VALUES(null, '$date', '$poczatek_pracy', '$koniec_pracy', '$poczatek_przerwy', '$koniec_przerwy'," . licz_przerwe_min() . "," . przerwa_netto_min() . "," . czas_przepracowanego_dnia_mod() . "," . czas_przepracowanego_dnia_int() . "," . suma_dnia() . ")";
            
            if( $db_connect->query($query)){
                
                echo 'Godziny zostały zapisane';
                header("Location:index.php");
                exit();
                
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
 * Suma całkowita godzin netto pracy w postaci Int
 */
function czas_przepracowanego_dnia_int() {
    
    if( isset($_GET['rozpoczecie_pracy']) && isset($_GET['koniec_pracy']) ) {
        
        $poczatek_pracy = $_GET['rozpoczecie_pracy'];
        $koniec_pracy = $_GET['koniec_pracy'];
        
        $czas_pracy_brutto = strtotime($koniec_pracy) - strtotime($poczatek_pracy) - przerwa_netto();
        $czas_pracy_netto = $czas_pracy_brutto  / 60;
        $czas_pracy_modulo = $czas_pracy_netto % 60;
        $czas_pracy_modulo = czas_pracy_modulo($czas_pracy_modulo);
        $czas_pracy_netto = $czas_pracy_netto / 60;
        $czas_pracy_netto = (int)$czas_pracy_netto;
        $wynik = $czas_pracy_netto;
    }
    
    return $wynik ;
    
}


/**
 * Suma całkowita minut netto pracy w postaci Int
 */
function czas_przepracowanego_dnia_mod() {
    
    if( isset($_GET['rozpoczecie_pracy']) && isset($_GET['koniec_pracy']) ) {
        
        $poczatek_pracy = $_GET['rozpoczecie_pracy'];
        $koniec_pracy = $_GET['koniec_pracy'];
        
        $czas_pracy_brutto = strtotime($koniec_pracy) - strtotime($poczatek_pracy) - przerwa_netto();
        $czas_pracy_netto = $czas_pracy_brutto  / 60;
        $czas_pracy_modulo = $czas_pracy_netto % 60;
        $czas_pracy_modulo = czas_pracy_modulo($czas_pracy_modulo);
        $wynik = $czas_pracy_modulo;
    }
    
    return $wynik ;
    
}


/**
 * Suma całkowita godzin i minut netto pracy dnia w postaci float
 */
function suma_dnia() {
    
    $day_finish = czas_przepracowanego_dnia_int() . "." . czas_przepracowanego_dnia_mod();
    $day_finish = czas_pracy_modulo($day_finish);
    return $day_finish;
    
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


/**
 * Funkcja wyświetlajaca tabele godzin
 */
function show_table_hours() {
    
    global $db_connect;
    
    if( !$db_connect->connect_errno ) {
        
        $query = "SELECT * FROM czas ORDER BY date ASC";
        
        if( $result = $db_connect->query($query)  ) {
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
                echo '<td><a href="index.php?delete=' . $row_table['id'] . '">Usuń</a></td>';
                echo '</tr>';
                
            }
          
            echo '</table>';
            
            
        } else {
            
            die('<p class="alert alert-danger">Wystąpił błąd przy wyświetlaniu zawartości tabeli.</p>');
            
        }
        
        if( isset($_GET['delete']) ) {
            
            $delete_id = $_GET['delete'];
            $query_delete = "DELETE FROM czas WHERE id=$delete_id";
            if($db_connect->query($query_delete)){
               header("Location:index.php");
               exit;
                
            } else {
            
                die('<p class="alert alert-danger">Wystąpił błąd przy usuwaniu wiersza tabeli.</p>');
            
            }
            
        }
        
    } else {
        
        echo 'Wystąpił błąd podczas połączenia z serwerem.';
        
    }
    
    $db_connect->close();
    
}


/**
 * Funkcja dodająca godziny urlopu
 */
function add_urlop() {
    
    global $db_connect;
    
    if (isset($_GET['zapisz_urlop'])) {
        
        $date_urlop = $_GET['data_urlop'];
        $urlop = $_GET['godz_urlop'];
        
        if( !empty($date_urlop) && !empty($urlop) ) {
            
            $date_urlop = htmlspecialchars($date_urlop);
            $urlop = htmlspecialchars($urlop);
            
            $query = "INSERT INTO czas VALUES(null, '$date_urlop', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '$urlop','$urlop'  )";
            
            
            if( $db_connect->query($query)){
                
                echo 'Godziny zostały zapisane';
                header("Location:index.php");
                exit;
                
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
 * Funkcja sumujaca wszystkie godziny z miesiaca
 */
function suma_godzin() {
    
    $db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if( !$db_connect->connect_errno ) {
        
        $query = "SELECT * FROM czas";
        
        if( $result = $db_connect->query($query)  ) {
            $suma_dnia_int = 0;
            $suma_dnia_mod = 0;
            while( $row_table = $result->fetch_assoc() ) {
                     
                $suma_dnia_int = $suma_dnia_int + $row_table['int_sum']++;
                $suma_dnia_mod = $suma_dnia_mod + $row_table['modulo']++;
                
            }
            
            $suma_dnia_mod_mod = $suma_dnia_mod % 60;
            $suma_dnia_mod_mod = czas_pracy_modulo($suma_dnia_mod_mod);
            $suma_dnia_mod_int = $suma_dnia_mod / 60;
            $suma_dnia_mod_int = (int)$suma_dnia_mod_int;
            
            $suma_dnia_int = $suma_dnia_int + $suma_dnia_mod_int;
            $suma_dnia_int = $suma_dnia_int . "." . $suma_dnia_mod_mod;
            
    
            return $suma_dnia_int . '<br>'; 
          
            
        }
        
    } else {
        
        echo 'Wystąpił błąd podczas połączenia z serwerem.';
        
    }
    
    $db_connect->close();
    
}
 

function date_date() {


$miesiac=array('Jan' => 'Stycznia',
            'Feb' => 'Luty',
   'Mar' => 'Marzec',
   'Apr' => 'Kwiecień',
   'May' => 'Maj',
   'Jun' => 'Czerwiec',
   'Jul' => 'Lipiec',
   'Aug' => 'Sierpień',
   'Sep' => 'Wrzesień',
   'Oct' => 'Pazdziernik',
   'Nov' => 'Listopad',
   'Dec' => 'Grudzień');


$month = date("M"); 
$day = date("j"); 
$year = date('Y');
    
 
echo $day . ' '; 
echo $miesiac[$month] . ' '; 
echo $year; 


    
}


?>