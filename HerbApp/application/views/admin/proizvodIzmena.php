
<table class="table">
    <tr >
        <td><label>Naziv: </label></td>
        <td><input type="text" name="naziv" value=<?php echo $proizvod->naziv; ?> id="naziv" /></td>
    </tr>
    
    
    <tr style="height:100px;">
        <td><label>Serijski broj: </label></td>
        <td><input type="text" name="serBr" value=<?php echo $proizvod->serBr; ?> id="serBr" /></td>
    </tr>
    
    
    <tr style="height:400px;" valign="middle">
	
		<td align=center><h4>Lista sirovina koje proizvod sadrzi:</h4></br>
		<table id="lista" class="table">
		
		</table>
				
		</td>
        
		
		
		
	<td align="right" >
		
		
		<!--tabela sa sirovinama-->
	<div style="width:600px" class="input-group">
	<span class="input-group-addon">Dodaj sirovine:</span>

    <input id="filter" type="text" class="form-control" placeholder="Trazi...">
    </div>
	
    <div class="tablecontainer">
	<table  class="table table-condensed table-responsive table-striped"> 
    <thead>
        <tr class="specTR">
            <th class="specTH">Naziv</th>
            <th  class="specTH">Serijski broj</th>
            <th  class="specTH"></th>
        </tr>
    </thead>
    <tbody class="searchable spectbody" >
	
	
	
					<?php foreach ($sirovine as $val) { ?>
					 <tr  class="specTR">
						<td  class="specTH"><?php echo $val->naziv; ?></td>
						<td  class="specTH"><?php echo $val->serBr; ?></td>																		<!--dugmence za modal-->
						<td  class="specTH"> <button type="button" class="btn btn-success mojModal" data-id=<?php echo $val->idSirovine;?> data-name=<?php echo $val->naziv;?>   data-toggle="modal" data-target="#myModal">dodaj</button></td>
							</tr>	
					<?php } ?>
					
    </tbody>
</table>
		
</div>
		
	</td>
    </tr>
   
    <tr>
        <td colspan='2' align='center'><input type='button' name='potvrdi' value='Potvrdi' class='btn btn-success' onClick="UPDATE()"/>
    </tr>
    
    <tr>
        
        <?php
            echo form_open('Admin/prozivodiPregled');
            echo "<td colspan='2' align='center'><input type='submit' name='odustani' value='Odustani' class='btn btn-default' />";
			echo form_close();
        ?>
    </tr>
	 <tr>
        
        <?php
            echo form_open('Admin/deleteProizvod/'.$proizvod->idProizvoda);
            echo "<td colspan='2' align='center'><input type='submit' name='obrisi' value='Obrisi' class='btn btn-danger' />"; echo form_close();
        ?>
    </tr>
	
	
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       
      </div>
      <div class="modal-body">
	 
               <h2> <div id="sirID" ></div></h2>
			   <br/>
			   Količina sirovine u proizvodu: <input type="number" min="0" id="kol" >


      </div>
      <div class="modal-footer" align="center">
        <button align="center" type="button" name="dodaj" class="btn btn-success">Dodaj sirovinu</button>

      </div>
    </div>
  </div>
</div>
<script>

var idpr=<?php echo $proizvod->idProizvoda; ?>;
var sirnaz='';
var sirovine=[]; //sve sirovine
var sir={'naziv':'', 'kolicina':'0'};//objekat iz niza sirovine
var nazivi=<?php echo json_encode($nazivi); ?>;
var kolicine=<?php echo json_encode($kolicine); ?>;


var naz= $.map(nazivi, function(el) { return el; });
var kol= $.map(kolicine, function(el) { return el; })
for (var i = 0; i < naz.length; i++) {
         sir={'naziv': naz[i], 'kolicina': kol[i] };
		 sirovine.push(sir);
		 
}

    for (var i = 0, l = sirovine.length; i < l; i++) {
    var obj = sirovine[i];
    $("#lista").append("<tr><td>"+obj['naziv']+"</td><td>"+obj['kolicina']+"</td><td><a class='text-danger' id="+i+" > <span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a></td></tr>");
	}

//skripta za pretragu
 $(document).ready(function () {

    (function ($) {

        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })

    }(jQuery));

});


//skripta za modal
$(document).on("click", ".mojModal", function () {
	
     var sirovina = $(this).data('name');
     $(".modal-body #sirID").html( sirovina );
	 sirnaz=sirovina;
	 
});


//skripta za kolicinu iz modala    
$('button[name="dodaj"]').click(function() {
	
var value = $('input[id="kol"]').val();
if (value=='') alert("Unesite kolicinu!");
else{
 sir={naziv:sirnaz, kolicina:value};
 sirovine.push(sir);
 var ind=sirovine.length-1;
 $("#lista").append("<tr><td>"+sir['naziv']+"</td><td>"+sir['kolicina']+"</td><td><a class='text-danger' id="+ind+" > <span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a></td></tr>");
 $('#myModal').modal('hide');

 }
 
 
 
 });
 
 //skripta za uklanjanje sirovine iz niza i iz liste

 $(document).on("click", "a", function(){
    var indeks=$(this).attr('id');
	//alert(indeks);
	sirovine.splice(indeks,1);
	$("#lista").html("");
	
	for (var i = 0, l = sirovine.length; i < l; i++) {
    var obj = sirovine[i];
     $("#lista").append("<tr><td>"+obj['naziv']+"</td><td>"+obj['kolicina']+"</td><td><a class='text-danger' id="+i+" > <span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span></a></td></tr>");
	}
	 
	 });
	
//kreiranje novog proizvoda	
 function UPDATE(){
	  var nazivi=[];
	  var kolicina=[];
	  var naziv=document.getElementById("naziv").value;
      var serBr=document.getElementById("serBr").value;
	  
	for (var i = 0, l = sirovine.length; i < l; i++) {
		var obj = sirovine[i];
		nazivi[i]=obj['naziv'];
		kolicina[i]=obj['kolicina'];
		
		
	}
	
	var base_url = '<?php echo site_url();?>';
	$.ajax({
                    url : base_url + '/admin/updateProizvod',
                    type : 'POST', //the way you want to send data to your URL
                    data : {'sirovine' : nazivi, 'kolicine': kolicina , 'naziv' :naziv, 'serbr': serBr, 'idPr' :idpr},
					datatype:'json',
                    success : function(res){ alert("Uspešno azuriran proizvod!");
                    },
					error: function() {alert("error!")},
                });
					 
	 }      

	
</script>


<style>

.tablecontainer { width: 600px; overflow; hidden;}
.specTR {display: block; }
.specTH { width: 200px; }
.spectbody { display: block; height: 200px; overflow: auto;}

</style>