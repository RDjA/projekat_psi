<html style="height:100%">
   

   <head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/nav.css'); ?>" >


	   <title>
           HerbApp 
        </title>
        <script>
            function validacija() {

                var x = document.getElementById("korisnickoIme").value;
                if (x == null || x == "") {
                    alert("Korisnicko ime nije uneto");
                    return false;
                }
                x = document.getElementById("lozinka").value;
                if (x == null || x == "") {
                    alert("Lozinka nije uneta");
                    return false;
                }
                var e = document.getElementById("kategorija");
                x = e.selectedIndex;
                if (x == -1){
                    alert("Kategorija nije izabrana");
                    return false;
                }


            }
        </script>
    </head>
    
 <body style="height:100%;">
 
 
 <div class="container-fluid">   
 
 
 
 <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <a class="navbar-brand" rel="home" href="#" title="pocetna">
        <img style="max-width:120px; margin-top: -15px;"
             src="<?php echo base_url('assets/img/logo.png'); ?>">
    </a>

      </div>
    </nav>
 
 
	




  <div class="row" style="padding-top:5%;">
						<div class="col-md-2 column"></div>
						<div class="col-md-8 column"> <?php echo $body; ?></div>
						<div class="col-md-2 column"></div>
					</div>   
       </div>
	    
	 
             
    </body>
	 <footer class="footer" style="position:absolute;bottom:0;width: 100%;height: 60px;background-color: #f5f5f5;">
      <div class="container">
        <p class="text-muted">Tim RĐA © 2015</p>
      </div>
    </footer>
	<script>

</script>
</html>
