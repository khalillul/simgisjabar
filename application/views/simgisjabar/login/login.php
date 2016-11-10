<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Login ke Aplikasi</title>
		<link rel="shortcut icon" href="<?php echo base_url();?>assets/login/images/logo.png">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/login/css/style.css" />
		
		<script>
		var base_url = '<?php echo base_url(); ?>';</script>
		<script src="<?php echo base_url();?>assets/login/js/modernizr.custom.63321.js"></script>
		<script src="<?=base_url().'assets/'?>js/jquery/jquery.min.js"></script>
		<!--<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/default.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/login.js" type="text/javascript"></script>-->
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		
		<script>
			$(document).ready(function(){   
				var msg = "<?php if($error){echo $errorMessage;}else{echo '';} ?>";
				if(msg!=''){
					$("#note h3").html(msg);
					$("#note").slideDown("slow");
					setTimeout(function() { $("#note").slideUp(); }, 3000);
				}
			});
		</script>
    </head>
    <body>
		<div id="note" style="display:none">
			<h3>You smell good.</h3>
		</div>
        <div class="container">
		
			<!-- Codrops top bar -->
			<header>
			
				<h1>Selamat Datang</h1>
				<h2><strong>Sistem Informasi Geografis Wilayah Pertanian</strong></h2>
				<h2><strong>Propinsi Jawa Barat</strong></h2>
				
				<img src='<?php echo base_url();?>assets/login/images/logo.png' alt='uog'/>
				<h5 style='margin-top:30px;'>Silahkan Login Untuk Mengakses Aplikasi</h5>
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>
				<?if(isset($pesan)){?>
					<div class="support-note">
						<span class="note-ie"><?=$pesan?></span>
					</div>
				<?}?>
				
			</header>
			<section class="main">
				<form class="form-1" action="<?=base_url()?>index.php/auth/login" method="post"> <!--onsubmit="return loggingin();"-->
					<p class="field">
						<input type="text" id="username" name="username" placeholder="Username">
						<i class="icon-user icon-large"></i>
					</p>
						<p class="field">
							<input type="password" id="password" name="password" placeholder="Password">
							<i class="icon-lock icon-large"></i>
					</p>
					<p class="submit">
						<button id="do_login" type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
					</p>
				</form>
			</section>
        </div>
    </body>
</html>
