
                        <form method="get" action="index.php?action=wybor&wybor=urlop">
                         
                           <div class="form-group">
                               <p>
                                   <label for="data_urlop">Data: </label>
                                   <input type="text" name="data_urlop" class="form-control" placeholder="Wpisz datę">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="godz_urlop">Ilość Godzin Urlopu </label>
                                   <input type="text" name="godz_urlop" class="form-control" placeholder="Godzin Urlopu">
                               </p>
                           </div>
                           <div class="form-hours">
                                <p class="glyphicon glyphicon-info-sign alert alert-info">Data musi byc podawana w formacie RRRR-MM-DD zaś godzina w GG:MM</p>
                            </div> 
                           <input type="submit" name="zapisz_urlop" value="Zapisz i Przelicz" class="btn btn-primary">
                        </form>
                        