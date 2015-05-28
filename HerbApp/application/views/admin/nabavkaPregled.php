
<h2>Arhivirani zahtevi</h2>
    <table class="table">
        <th>Sirovina</th>
        <th>Serijski broj</th>
        <th>Kolicina</th>
        <th>Datum</th>
        <th>Status</th>
        <th></th>
        <th></th>
        
      <?php foreach ($zahtevi as $zahtev){ ?>
            
            <td><?php echo $sirovine[$zahtev->idZahtevSirov]->naziv; ?></td>
            <td><?php echo $sirovine[$zahtev->idZahtevSirov]->serBr; ?></td>
            <td><?php echo $zahtev->kolicina ?></td>
            <td><?php echo $zahtev->datumComplete ?></td>
            <td><?php echo $zahtev->status ?></td>
            
            <td>
                <?php echo form_open('admin/showZahtevNabavka/'.$zahtev->idZahtevProiz); ?>       
                        <p>
                            <input type ="submit" value="Edit" class="btn btn-success"/>
                        </p>
        
                <?php echo form_close(); ?>
            </td>
            
            <td>
                <?php echo form_open('admin/deleteZahtevNabavka/'.$zahtev->idZahtev); ?>       
                        <p>
                            <input type ="submit" value="Delete" class="btn btn-danger"/>
                        </p>
        
                <?php echo form_close(); ?>
            </td>
            
      <?php } ?>
    </table>

                <?php echo form_open('admin/newZahtevNabavka/'); ?>       
                        <p>
                            <input type ="submit" value="Nov Zahtev" class="btn btn-success"/>
                        </p>
        
                <?php echo form_close(); ?>



