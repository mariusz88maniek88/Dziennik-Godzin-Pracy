
                        <form method="POST" >
                         
                           <div class="form-group">
                               <p>
                                   <label for="data">Data: </label>
                                   <input type="date" name="data_update" class="form-control" value="<?php echo $edit_date; ?>">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="rozpoczecie_pracy_update">Rozpoczecie pracy(Data i czas): </label>
                                   <input type="text" name="rozpoczecie_pracy_update" class="form-control" value="<?php echo $edit_pocz_pracy; ?>">
                               </p>
                           </div>
                            <div class="form-group">
                               <p>
                                   <label for="koniec_pracy_update">Zakończenie pracy(Data i czas): </label>
                                   <input type="text" name="koniec_pracy_update" class="form-control" value="<?php echo $edit_kon_pracy; ?>">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="czas_rozp_prz_update">Początek przerwy: </label>
                                   <input type="text" name="czas_rozp_prz_update" class="form-control" value="<?php echo $edit_pocz_przerwy; ?>">
                               </p>
                           </div>
                           <div class="form-group">
                               <p>
                                   <label for="czas_kon_prz_update">Koniec przerwy: </label>
                                   <input type="text" name="czas_kon_prz_update" class="form-control" value="<?php echo $edit_kon_przerwy; ?>">
                               </p>
                           </div>
                           <div class="form-hours">
                                <p class="glyphicon glyphicon-info-sign alert alert-info">Data musi byc podawana w formacie RRRR-MM-DD zaś godzina w GG:MM</p>
                            </div> 
                           <input type="submit" name="zaktualizuj_godziny" value="Zaktualizuj" class="btn btn-primary">
                        </form>
