<?php
	require('inc/timeasset.php');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <title>Dark Souls Character Planner: Frequently Asked Questions</title>
  <meta name="description" content="Dark Souls Character Planner.  Gives you the ability to enter nearly everything to build your character from the ground up.  Includes HP, stamina, attunement, armor selector, all your defenses, weapon selector and AR calculator as well as including armor, rings, spells, covenants and weapon effects.">
  <meta name="keywords" content="Dark Souls,darksouls,dks,character builder,stat planner,character creator,dark souls character builder,darksouls character builder,dks character builder,dark souls stat planner,character planner,dark souls character planner, darksouls character planner, dks planner">
  <link type="text/css" rel="stylesheet" href="css/style.css<?php echo $timeasset;?>" />
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
			<div class="over analy">
					<h2>Features at a glance</h2>
					<hr>
					<center><a href="/darksouls/img/fq/_info.png"><img src="img/fq/_info.png" style="max-width:99%;"/></a></center>
					<h2>Frequently Asked Questions</h2>
					<div class="padding">
					<hr class="mmar">
					<ul>
						<li><a href="#a1">"Can I save my builds?"</a></li>
						<li><a href="#a2">"How do I change my weapon's upgrade path?"</a></li>
						<li><a href="#a8">"Are all weapons able to chage their upgrade path?"</a></li>
						<li><a href="#a3">"What is the 'Best Class Finder' and how do I use it?"</a></li>
						<li><a href="#a9">"What is 'Text Export'?"</a></li>
						<li><a href="#a11">"What is Nerfed EK Set?"</a></li>
						<li><a href="#a10">"<del>Im having trouble with this site on mobile!</del>"</a></li>
						<li><a href="#a4">"What is the active weapon?"</a></li>
						<li><a href="#a5">"What does turning on the 2 hand option do?"</a></li>
						<li><a href="#a6">"What does disabling AutoUpdate: Best Class Finder do?"</a></li>
						<li><a href="#a7">"Why should I disable Animations?"</a></li>
					</ul>
					<hr>
					<div class="hov">
						<a name="a1"></a>
						<h3>Can I save my builds?</h3>
						<p>Yes, by using the share link you can effectively save your current build.</p>
						<p>A new feature in saving builds is the ability to upload your build making it available for others to browse.
						This also gives you a shorter link which is easier to share then the much longer share link.
						Please only save a build once!  Duplicates will be removed with my discretion.</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a2"></a>
						<h3>How do I change my weapon's upgrade path?</h3>
						<p class="clearfix"> <a href="img/fq/upgradepath.png" target="_blank" class="highlgh"><img src="img/fq/upgradepath.png" height="125" /></a>To change your weapon's upgrade path you first need to have a weapon that can have different upgrade paths.
						Then by clicking on the image above the weapon it will bring up a dialog option in which you can select your weapon's path.</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a8"></a>
						<h3>Are all weapons able to change thier upgrade path?</h3>
						<p class="clearfix">No, only <em>normal</em> weapons and bows can have thier path changed.  
						Special/unique weapons, catalysts and talismans do not have seperate upgrade paths, while the paths for shields are not inlcuded.
						Clicking the image icon while any of these are selected will prevent the path selector from popping up.</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a3"></a>
						<h3>What is the 'Best Class Finder' and how do I use it?</h3>
						<p class="clearfix"> <a href="http://static.mugenmonkey.com/img/fq/bcfull.png" target="_blank" class="highlgh"><img src="img/fq/bcfprev.png" height="125" /></a>
						The "Best Class Finder" is a feature that attempts to give you the best class for your entered stats.
						This feature is found by clicking the top left tab.
						By default it will track any stats you enter into the regular editor, but will only apply any changes if you press the 'Apply button'.
						</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a9"></a>
						<h3>What is 'Text Export'?</h3>
						<p class="clearfix">
						Text Export is meant for an easy way to copy/paste your build details if you do not want to use a link.
						Useful if you just want to share stats/equpiment/spells.  If a stat is at base it will display a '-' instead of the stat.
						</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a11"></a>
						<h3>What is Nerfed EK Set?</h3>
						<p class="clearfix">
						There is a known bug in which some users have the nerfed Elite Knight Set and others having the unnerfed set.  You can choose to use the nerfed set or not, the only difference being the poise values for each piece.  Nerfed has less(34 total) unnerfed has more(46 total).
						</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a10"></a>
						<h3>Im having trouble with this site on mobile!</h3>
						<p class="clearfix">
						<del>A known problem with this site on some mobile phones is the spell selector menu.  Sometimes the scrollbar is hidden even tho it is there making it seem as if you only have 4 spell slots.
						Try to zoom in and scroll the box to reveal the rest of the spell slots.</del>  This should no longer affect any mobile device as the placement for this menu has changed. And a mobile friendly version is currently in the works, so look for it in the coming weeks.
						</p>
					</div>
					<hr>
					
					<div class="hov">
						<a name="a4"></a>
						<h3>What is the active weapon?</h3>
						<p class="clearfix"> <a href="http://static.mugenmonkey.com/img/fq/active.png" target="_blank" class="highlgh"><img src="img/fq/active.png" height="114" /></a>
						The active weapon is the weapon who's hand is currently highlighted blue. Since only one of each weapon(left/right) can be selected at a time, this ensures any weapon effects are only applied if they are active.
						This prevents false stat increases and preserves the accuracy of the builder.
						</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a5"></a>
						<h3>What does turning on the '2 hand' option do?</h3>
						<p class="clearfix">
						The '2 Hand Option' enables weapons to be handled '2 handed'.  Meaning, your strength stat is increased by a factor of 1.5. Usually enabling you to use weapons with higher strength requirements without
						the stat investment.  This only works on right hand weapons however, and regular bows in either hand.
						</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a6"></a>
						<h3>What does disabling AutoUpdate: Best Class Finder do?</h3>
						<p class="clearfix">
						The best class finder is a feature the finds the best class for the stats you enter. By default it works in parallel with the stats you enter into the front editor and by effect, can put extra load on slower machines. If you experience hangups after changing stats or equipment then disabling may help.
						</p>
					</div>
					<hr>
					<div class="hov">
						<a name="a7"></a>
						<h3>Why should I disable Animations?</h3>
						<p class="clearfix">
						By default animations are enabled. If you experience slow downs during an animation then disabling may help.</p>
					</div>
					<hr>
					</div>
					
			</div>
		
	
		</div>
	</div>
	<?php include('footer.php'); ?>
	</div>
 

  
</body>
</html>