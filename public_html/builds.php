<?php
	require('inc/timeasset.php');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <title>Dark Souls Character Planner: Saved Builds</title>
  <meta name="description" content="Dark Souls character builder.  Gives you the ability to enter nearly everything to build your character from the ground up.  Includes HP, stamina, attunement, armor selector, all your defenses, weapon selector and AR calculator as well as including armor, rings, spells, covenants and weapon effects.">
  <meta name="keywords" content="Dark Souls,darksouls,dks,character builder,stat planner,character creator,dark souls character builder,darksouls character builder,dks character builder,dark souls stat planner,character planner,dark souls character planner, darksouls character planner, dks planner">
  <link type="text/css" rel="stylesheet" href="css/style.css<?php echo $timeasset;?>423421" />
  <script src="js/libs/modernizr-2.5.2.min.js"></script>
  <script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-29538296-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

  </script>
</head>
<body>
<?php include('thead.php'); ?>
	<div id="container">
		<div class="cpadding">
			<header>
				<div class="infobox"><?php include('info.php'); ?></div>
				<a href="./"><img src="http://static.mugenmonkey.com/img/_logo.png" width="362" height="82" class="logo" /></a>
				
			</header>
			<?php include('nav.php'); ?>
			<div role="main" id="content">
				
		<?php include('inc/builds.php'); ?>
	
		</div>
	</div>
	
	<?php include('footer.php'); ?>
	</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
<script>
$(document).ready(function(){$('.login').click(function(){$(this).addClass('hover');$('.login_form').addClass('shown');if(!$('.login').hasClass('intent')){$('.login').addClass('intent');$('.login,.login_form').click(function(event){event.stopPropagation();});} else if($('.login').hasClass('intent')){$('.login').removeClass('hover intent');$('.login_form').removeClass('shown');$(document).unbind('click');}$(document).click(function(){$('.login').removeClass('hover intent');$('.login_form').removeClass('shown');$(document).unbind('click');});return false;});$(".votearrows").click(function(){var b=($(this).hasClass("vup"))?"up":"down";var a=$(this).prop("title");$.get("votes.php",{vtyp:b,id:a},function(f){var c=$(".kvot.n"+a);var g=$(".nvot.n"+a);var e=parseInt(c.text());var h=parseInt(g.text())+1;if(f=="up"){c.text(e+5);g.text(h)}else{if(f=="down"){c.text(e-3);g.text(h)}else{var d=$(".tvut.n"+a);d.removeClass("hidden").css("display","inline").fadeOut(2000,function(){d.addClass("hidden")})}}})});$('.favorites').click(function(){var k=$(this);var saveid=$(this).prop('href').split('#')[1];$.get("fave.php",{fave:saveid},function(f){if(f == 'success'){k.parent().html('favorited');}else{return false;}});return false;});});
</script>
</body>
</html>