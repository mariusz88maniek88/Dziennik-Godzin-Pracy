<?php 

require '../system/db_connect.php';
include 'function.php'; 

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona główna</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header id="header">
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1>Dziennik Godzin Pracy</h1>
                        <?php save_hours(); ?>
                    </div>
                </div>
            </div> 
        </div>
    </header>
    <section id="content">
        <div class="container container-main">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                   <div class="tabsy_menu">
                      <p><label>Wybierz Formularz Dnia:</label></p>
                       <ul class="nav nav-tabs">
                          <li role="presentation">
                              <a href="index.php?action=wybor&wybor=urlop">Urlop</a>
                          </li>
                          <li role="presentation">
                              <a href="index.php?action=wybor&wybor=godziny">Godziny</a>
                          </li>
                        </ul>
                   </div>
                    
                <?php show_from(); ?>
                    
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="tabela_wynikow">
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
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>