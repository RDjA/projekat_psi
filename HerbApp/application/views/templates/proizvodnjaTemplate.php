

<html style="height:100%">
   
   <head>
   
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/stilovi.css'); ?>"> -->
   
   
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/nav.css'); ?>" >



   
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script>
        $(function() {
          $( "#datepicker" ).datepicker();
        });
        </script>



	   <title>
           HerbApp Proizvodnja
        </title>
    </head>
    
 <body style="height:100%;">
 
 
 <div class="container-fluid">   
 
 
 <!--navbar-->
 <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <a class="navbar-brand" rel="home" href="<?php echo site_url('proizvodnja/listaProizvoda/') ?>" title="pocetna">
        <img style="max-width:120px; margin-top: -15px;"
             src="<?php echo base_url('assets/img/logo.png'); ?>">
    </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
              
            <li> <a href="<?php echo site_url('proizvodnja/listaProizvoda/') ?>">Proizvodi</a></li>
            <li><a href="<?php echo site_url('proizvodnja/redZaProizvodnju/') ?>">Red za Proizvodnju</a></li>
            <li><a href="<?php echo site_url('proizvodnja/showArhiva/') ?>">Arhiva</a></li>
            </ul>
			
		<ul class="nav navbar-nav" style="float:right">
            <li><a href="<?php echo site_url('login/logout/') ?>">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
 
 
	


<!-- unutrasnji sadrzaj-->

  <div class="row" style="padding-top:5%;">
						<div class="col-md-2 column"></div>
						<div class="col-md-8 column"> <?php echo $body; ?></div>
						<div class="col-md-2 column"></div>
					</div>

     
           
       </div>
	    
	 
      <!-- footer -->       
    </body>
	 <footer class="footer" style="position:absolute;bottom:0;width: 100%;height: 60px;background-color: #f5f5f5;">
      <div class="container">
        <p class="text-muted">Tim RĐA © 2015</p>
      </div>
    </footer>
	<script>

</script>
</html>
