
                        <form method="get">
                         
                         <h3>Edytuj ustawienia...</h3>
                         
                           <div class="form-group">
                               <p>
                                   <label for="data">Data: </label>
                                   <input type="text" name="data" class="form-control" placeholder="Wpisz datę">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="rozpoczecie_pracy">Rozpoczecie pracy(Data i czas): </label>
                                   <input type="date" name="rozpoczecie_pracy" class="form-control" placeholder="RRRR-MM-DD GG:MM">
                               </p>
                           </div>
                            <div class="form-group">
                               <p>
                                   <label for="koniec_pracy">Zakończenie pracy(Data i czas): </label>
                                   <input type="text" name="koniec_pracy" class="form-control" placeholder="RRRR-MM-DD GG:MM">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="czas_rozp_prz">Początek przerwy: </label>
                                   <input type="text" name="czas_rozp_prz" class="form-control" placeholder="GG:MM">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="czas_kon_prz">Koniec przerwy: </label>
                                   <input type="text" name="czas_kon_prz" class="form-control" placeholder="GG:MM">
                               </p>
                           </div>
                           <div class="form-hours">
                                <p class="glyphicon glyphicon-info-sign alert alert-info">Data musi byc podawana w formacie RRRR-MM-DD zaś godzina w GG:MM</p>
                            </div> 
                           <input type="submit" name="zapisz_godziny" value="Edytuj" class="btn btn-primary">
                        </form>
                        