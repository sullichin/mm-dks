<?php
	require('inc/timeasset.php');
	require('inc/contype.php');
	if(isset($_GET['c'])) {
		$ref = preg_replace('/[^0-9]/si','', $_GET['c']);
		if(!empty($ref) && $ref == $_GET['c']){
			$query = @mysql_query('SELECT `b64`,`title`,`auth`,`desci` FROM `saved_builds` WHERE `ref`="'.$ref.'" LIMIT 1');
			while($data = mysql_fetch_array($query)){
				$base64 = $data['b64'];
				$btitle = $data['title'];
				$bauth = $data['auth'];
				$bdes = $data['desci'];
			}
		}
	}
	$pga = true;
	$ga = <<<TEXT
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
TEXT;
		$lists = false;
		$upmethod = 'new';

	if(isset($_COOKIE['user']) && isset($_COOKIE['token'])){
		$token = $_COOKIE['token'];
		$allLists = mysql_query("SELECT * FROM `lists` WHERE `owner`='{$token}' ORDER BY `id` ASC");
		if(mysql_num_rows($allLists) == 0){
			$lists = false;
			$upmethod = 'new';
		}else{
			$lists = '';
			while($data = mysql_fetch_array($allLists)){
				$lists .= '<option value="'.$data['listid'].':::::'.$data['listtitle'].'">'.$data['listtitle'].'</option>';
			}
			$upmethod = 'dif';
		}
	}
?>


<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/icon_ex.png"/>
  <title>Dark Souls Character Planner</title>
  <meta name="description" content="Dark Souls Character Planner.  Gives you the ability to enter nearly everything to build your character from the ground up.  Includes HP, stamina, attunement, armor selector, all your defenses, weapon selector and AR calculator as well as including armor, rings, spells, covenants and weapon effects.">
  <meta name="keywords" content="Dark Souls,darksouls,dks,character builder,stat planner,character creator,dark souls character builder,darksouls character builder,dks character builder,dark souls stat planner,character planner,dark souls character planner, darksouls character planner, dks planner">
  <link type="text/css" rel="stylesheet" href="css/style.css<?php echo $timeasset;?>6452" />
  <script src="js/libs/modernizr-2.5.2.min.js"></script>
  <?php if($pga) print($ga); ?>
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
			<div class="overlay"></div><div class="overlay2"></div>
			<form id="ma" onsubmit="return false;">
				<div id="textport">[<a name="text" class="rand noSelect">random</a>] [<a name="text" class="texti noSelect">text export</a>]</div>
				<?php 
				if(isset($btitle) && $btitle != 'Untitled'){
					echo "<div id='btitle'>Viewing build '$btitle' by ";
					if($bauth == 'Anonymous'){
						echo 'Anonymous';
					} else {
						echo "<a href='/darksouls/share?uid=".rawurlencode($bauth)."'>$bauth</a>";
					}
					echo '</div>';
				}
				?>
				<div id="texti">
					<span class="rcop">Ctrl+C to copy</span>
					<span class="tclos">close</span>
					
					<div class="cpadding">
						<textarea readonly no-resize class="smptext"></textarea>
					</div>
				</div>
				<div id="savedia" style="margin:-280px 0 0 -255px">
					<span class="tclos">close</span>
					
					<div class="cpadding">
						<div class="savecl">
						<h3>Save your build</h3>
						<hr><?php
							if($lists){ ?>
								
							<div><strong>Title</strong><sup>1</sup> <input type="text" maxlength="50" id="saveTitle" value="Untitled" /></div>
							<div><strong>Author</strong> <span class="toright"><?php echo $_COOKIE['user']; ?></span><input type="hidden" id="saveAuthor" value="<?php echo $_COOKIE['user']; ?>"/><input type="hidden" id="saveAuthorH" value="<?php echo $_COOKIE['token']; ?>"/></div>
							<?php if(strlen($lists) > 0) echo '<div><strong>Add to list</strong> <select class="right" id="lSelec">'. $lists .'</select> or </div>'; ?>
							
							<div>Make new list<input type="text" maxlength="25" id="savelist" value="New List title..." placeholder="New List title..." style="color:#aaa;" /></div>
							<div style="position:relative;"><textarea id="sevdes" maxlength="2000" lengthcut="true" style="width:100%;display:block;height:80px;font-size:13px;" placeholder="Short description, notes or things related to your build. Can include plain links."></textarea></div>
							<div class="clearfix"><div class="overit">Make public? <input type="checkbox" id="savePublic" checked="checked" /></div><button class="cancel" id="fcancel">Cancel</button> <button id="fsave">Save</button></div>
							
							<div class="datbox"></div>
							<hr>
							<p><strong>Note:</strong> Use this to save your build privately or make it public for others to see and use.
							You can also use this link to share the build.  Please only use this if your build is complete!</p>
							<p class="faded small">1: Max length is 50 characters, minimum is 4</p>
								
							<?php } else { ?>
							
							<div><strong>Title</strong><sup>1</sup> <input type="text" maxlength="50" id="saveTitle" value="Untitled" /></div>
							<div><strong>Author</strong><sup>1,2</sup> <input type="text" maxlength="50" id="saveAuthor" value="Anonymous"/></div>
							<div style="position:relative;"><textarea id="sevdes" maxlength="2000" style="width:100%;display:block;height:80px;font-size:13px;" placeholder="Short description, notes or things related to your build. Can include plain links."></textarea></div>
							
							<div class="clearfix"><div class="overit">Make public? <input type="checkbox" id="savePublic"/></div><button class="cancel" id="fcancel">Cancel</button> <button id="fsave">Save</button></div>
							<div class="datbox"></div>
							<hr>
							<p><strong>Note:</strong> Use this to save your build privately or make it public for others to see and use.
							You can also use this link to share the build.  Please only use this if your build is complete!</p>
							<p class="faded small">1: Max length is 50 characters, minimum is 4<br>2: Please do not use your email or real name. Use a forum name or something along those lines</p>
						<?php } ?>
						</div>
					</div>
				</div>
				<div id="minilink">
					<span class="tclos">close</span>
					
					<div class="cpadding">
						<div class="savecl">
						<h3>TinyURL Link Maker</h3>
						<div id="ministatus"></div>
						</div>
					</div>
				</div>
				<div id="settings" state="1"> <img src="http://static.mugenmonkey.com/img/settings24.png" class="tip" width="24" height="24" tex="Settings" /> </div>
				<!-- <div id="aropt" state="p"> <img src="img/analysis.png" class="tip" width="24" height="24" tex="Armor Optimizer" /> </div>
				<div id="dfinder" state="p"> <img src="img/tests.png" class="tip" width="24" height="24" tex="Damage Finder" /> </div> -->
				<div class="settings">
					<div class="padding">
						<div class="left">
							<div class="ytitle">Animations<hr class="nomargin"></div>
							<div>
								<div><input type="radio" name="animations" value="on" id="son" checked="checked" class="animate"/> <label for="son">Enabled</label></div>
								<div><input type="radio" name="animations" value="off" id="soff" class="animate"/> <label for="soff">Disabled</label></div>
							</div>
						</div>
						<div class="right">
							<div class="ytitle">Best Class Finder<hr class="nomargin"></div>
							<div>
								<div><input type="radio" name="autoupdate" value="on" id="ason" checked="checked" class="autoup"/> <label for="ason">Auto</label></div>
								<div><input type="radio" name="autoupdate" value="off" id="asoff" class="autoup"/> <label for="asoff">Manual</label></div>
							</div>
						</div>
						<div class="clear"></div>
						<br>
						<div class="left">
							<div class="ytitle">Path Selector<hr class="nomargin"></div>
							<div>
								<div><input type="radio" name="pathsel" value="on" id="pson" checked="checked" class="pathsel"/> <label for="pson">Auto</label></div>
								<div><input type="radio" name="pathsel" value="off" id="psoff" class="pathsel"/> <label for="psoff">Manual</label></div>
							</div>
						</div>
						<div class="right">
							<div class="ytitle">Use Nerfed EK Set<hr class="nomargin"></div>
							<div>
								<div><input type="radio" name="nerf" value="on" id="unek" checked="checked" class="nerf"/> <label for="unek">Yes</label></div>
								<div><input type="radio" name="nerf" value="off" id="onek" class="nerf"/> <label for="onek">No</label></div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="cselector" state='t'>
					<img src="http://static.mugenmonkey.com/img/content-reorder.png" class="tip" width="24" height="24" tex="Best Class Finder" />
				</div>
				<div class="crow fake">
					<div class="stretch">
						<div class="padding">
							<div class="formbox clearfix">
								<label for="startClass_fake" class="bold">Best Class</label> 
								<input type="text" maxlength="30" id="bclass_fake" class="wide" readonly fid="bcs" value="No stats yet..."/> 
								<img src="http://static.mugenmonkey.com/img/revert20b.png" width="20" height="20" id="revert_fake" class="tip" tex="Revert stats to default" />
							</div>
							<hr>
							<div class="titles">
								<span>Stat</span><div>Starting Desired</div>
							</div>
							<!-- Vitality -->
							<div class="formbox clearfix" fid="vtf" idm='statsf'>
								<label for="vitality_fake">Vitality</label> 
								<input type="text" maxlength="2" id="bvitality_fake" disabled fid="vtf" /> 
								<input type="text" maxlength="2" id="cvitality_fake" tabindex="2" fid="vtf" class="bgw" />
								<span class="arrow down_fake noSelect" id="uvitality_fake" fid="vtf"></span>
								<span class="arrow up_fake noSelect" id="dvitality_fake" fid="vtf"></span>
							</div>
							<!-- Attunement -->
							<div class="formbox clearfix" fid="atf" idm='statsf'>
								<label for="attunement_fake">Attunement</label> 
								<input type="text" maxlength="2" id="battunement_fake" disabled fid="atf" /> 
								<input type="text" maxlength="2" id="cattunement_fake" tabindex="3" fid="atf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="uattunement_fake" fid="atf"></span>
								<span class="arrow up_fake noSelect" id="dattunement_fake" fid="atf"></span>
							</div>
							<!-- Endurance -->
							<div class="formbox clearfix" fid="enf" idm='statsf'>
								<label for="endurance_fake">Endurance</label> 
								<input type="text" maxlength="2" id="bendurance_fake" disabled fid="enf" /> 
								<input type="text" maxlength="2" id="cendurance_fake" tabindex="4" fid="enf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="uendurance_fake" fid="enf"></span>
								<span class="arrow up_fake noSelect" id="dendurance_fake" fid="enf"></span>
							</div>
							<!-- Strength -->
							<div class="formbox clearfix" fid="stf" idm='statsf'>
								<label for="strength_fake">Strength</label> 
								<input type="text" maxlength="2" id="bstrength_fake" disabled fid="stf" /> 
								<input type="text" maxlength="2" id="cstrength_fake" tabindex="5" fid="stf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="ustrength_fake" fid="stf"></span>
								<span class="arrow up_fake noSelect" id="dstrength_fake" fid="stf"></span>
							</div>
							<!-- Dexterity -->
							<div class="formbox clearfix" fid="dxf" idm='statsf'>
								<label for="dexterity_fake">Dexterity</label> 
								<input type="text" maxlength="2" id="bdexterity_fake" disabled fid="dxf" /> 
								<input type="text" maxlength="2" id="cdexterity_fake" tabindex="6" fid="dxf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="udexterity_fake" fid="dxf"></span>
								<span class="arrow up_fake noSelect" id="ddexterity_fake" fid="dxf"></span>
							</div>
							<!-- Resistance -->
							<div class="formbox clearfix" fid="rsf" idm='statsf'>
								<label for="resistance_fake">Resistance</label> 
								<input type="text" maxlength="2" id="bresistance_fake" disabled fid="rsf" /> 
								<input type="text" maxlength="2" id="cresistance_fake" tabindex="7" fid="rsf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="uresistance_fake" fid="rsf"></span>
								<span class="arrow up_fake noSelect" id="dresistance_fake" fid="rsf"></span>
							</div>
							<!-- Intelligence -->
							<div class="formbox clearfix" fid="inf" idm='statsf'>
								<label for="intelligence_fake">Intelligence</label> 
								<input type="text" maxlength="2" id="bintelligence_fake" disabled fid="inf" /> 
								<input type="text" maxlength="2" id="cintelligence_fake" tabindex="8" fid="inf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="uintelligence_fake" fid="inf"></span>
								<span class="arrow up_fake noSelect" id="dintelligence_fake" fid="inf"></span>
							</div>
							<!-- Faith -->
							<div class="formbox clearfix" fid="ftf" idm='statsf'>
								<label for="faith_fake">Faith</label> 
								<input type="text" maxlength="2" id="bfaith_fake" disabled fid="ftf" /> 
								<input type="text" maxlength="2" id="cfaith_fake" tabindex="9" fid="ftf" class="bgw"/>
								<span class="arrow down_fake noSelect" id="ufaith_fake" fid="ftf"></span>
								<span class="arrow up_fake noSelect" id="dfaith_fake" fid="ftf"></span>
							</div>
							<hr>
							<div class="titles">
								<span>Stat</span><div>Starting Current</div>
							</div>
							<!-- Soul Level -->
							<div class="formbox clearfix" fid="slf" idm='statsf'>
								<label for="soulLevel_fake">Soul Level</label> 
								<input type="text" maxlength="3" id="bsoulLevel_fake" disabled fid="slf" /> 
								<input type="text" maxlength="3" id="csoulLevel_fake" tabindex="1" fid="slf" readonly class="bold"/>
								<span class="arrow down invisible" id="usoulLevel_fake" fid="slf"></span>
								<span class="arrow up invisible" id="dsoulLevel_fake" fid="slf"></span>
							</div>
							<hr>
							<div class="center">
								<button type="button" value="Apply Stats" id="apply">Apply Stats</button> <button type="button" value="Cancel" id="cancel">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				<div class="crow fake2">
					<div class="padding">
						<div class="f2lef">
							<span class="bold">Class Rankings</span>
							<hr>
								<div class="rnktitle"><span>&nbsp;&nbsp;&nbsp;# &nbsp;&nbsp;Class</span> Soul Level</div>
								<div class="rankings">
									<span class="faded">No stats entered yet.</span>
								</div>
						</div>
					</div>
				</div>
				
				<div id="wepTypeSel" goes=''>
					<div class="oger">
						<div class="filler" id="wepo">
							<div class="wepTyp" tpy="normal" id="tynor">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="normal" style="background-position:0;" class="im"/> Normal+15
							</div>
							<div class="wepTyp" tpy="crystal" id="tycry">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="crystal" style="background-position:-40px;" class="im"/> Crystal+5
							</div>
							<div class="wepTyp" tpy="lightning" id="tylgh">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="lightning" style="background-position:-60px;" class="im"/> Lightning+5
							</div>
							<div class="wepTyp" tpy="raw" id="tyraw">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="raw" style="background-position:-20px;" class="im"/> Raw+5
							</div>
							<div class="wepTyp" tpy="magic" id="tymag">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="magic" style="background-position:-80px;" class="im"/> Magic+10
							</div>
							<div class="wepTyp" tpy="enchanted" id="tyenc">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="enchanted" style="background-position:-100px;" class="im"/> Enchanted+5
							</div>
							<div class="wepTyp" tpy="devine" id="tydev">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="devine" style="background-position:-120px;" class="im"/> Divine+10
							</div>
							<div class="wepTyp" tpy="occult" id="tyocc">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="occult" style="background-position:-140px;" class="im"/> Occult+5
							</div>
							<div class="wepTyp" tpy="fire" id="tyfir">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="fire" style="background-position:-160px;" class="im"/> Fire+10
							</div>
							<div class="wepTyp" tpy="chaos" id="tycha">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="chaos" style="background-position:-180px;" class="im"/> Chaos+5
							</div>
						</div>
						<div class="filler" id="arpo">
							<div class="wepTyp" tpy="wooden" id="tywood">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="wooden" style="background-position:0;" class="it"/> Wooden Arrow
							</div>
							<div class="wepTyp" tpy="standard" id="tystand">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="standard" style="background-position:-20px;" class="it"/> Standard Arrow
							</div>
							<div class="wepTyp" tpy="large" id="tylarge">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="large" style="background-position:-40px;" class="it"/> Large Arrow
							</div>
							<div class="wepTyp" tpy="feather" id="tyfeather">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="feather" style="background-position:-60px;" class="it"/> Feather Arrow
							</div>
							<div class="wepTyp" tpy="firea" id="tyfire">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="firea" style="background-position:-80px;" class="it"/> Fire Arrow
							</div>
							<div class="wepTyp" tpy="poison" id="typoison">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="poison" style="background-position:-100px;" class="it"/> Poison Arrow
							</div>
							<div class="wepTyp" tpy="moonlight" id="tymoon">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="moonlight" style="background-position:-120px;" class="it"/> Moonlight Arrow
							</div>
							<div class="wepTyp" tpy="dragon" id="tydrag">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="dragon" style="background-position:-140px;" class="it"/> Dragonslayer Arrow
							</div>
							<div class="wepTyp" tpy="bwood" id="tybwood">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="bwood" style="background-position:-160px;" class="it"/> Wooden Bolt
							</div>
							<div class="wepTyp" tpy="bstandard" id="tybstand">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="bstandard" style="background-position:-180px;" class="it"/> Standard Bolt
							</div>
							<div class="wepTyp" tpy="bheavy" id="tybheavy">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="bheavy" style="background-position:-200px;" class="it"/> Heavy Bolt
							</div>
							<div class="wepTyp" tpy="bsniper" id="tybsniper">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="bsniper" style="background-position:-220px;" class="it"/> Sniper Bolt
							</div>
							<div class="wepTyp" tpy="blight" id="tyblight">
								<img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" goes='' typ="blight" style="background-position:-240px;" class="it"/> Lighting Bolt
							</div>
						</div>
					</div>
					
					<div class="wepArr1"></div>
					<div class="wepArr2"></div>
				</div>
				<div class="over">
				<div class="wrapper clearfix">
					<div class="crow">
						<div class="padding">
							<div class="formbox clearfix">
								<label for="startClass">Start Class</label> 
								<select id="startClass">
									<option value="warrior">4 - Warrior</option>
									<option value="knight">5 - Knight</option>
									<option value="wanderer">3 - Wanderer</option>
									<option value="thief">5 - Thief</option>
									<option value="bandit">4 - Bandit</option>
									<option value="hunter">4 - Hunter</option>
									<option value="sorcerer">3 - Sorcerer</option>
									<option value="pyromancer">1 - Pyromancer</option>
									<option value="cleric">2 - Cleric</option>
									<option value="deprived">6 - Deprived</option>
								</select>
								<img src="http://static.mugenmonkey.com/img/revert20b.png" width="20" height="20" id="revert" class="tip" tex="Revert stats to default" />
							</div>
							<hr>
							<div class="titles">
								<span>Stat</span><div>Starting Current</div>
							</div>
							<!-- Soul Level -->
							<div class="formbox clearfix" uid="sl" idm='stats'>
								<label for="soulLevel">Soul Level</label> 
								<input type="text" maxlength="3" id="bsoulLevel" disabled uid="sl" /> 
								<input type="text" maxlength="3" id="csoulLevel" tabindex="1" uid="sl" readonly class="bold"/>
								<span class="arrow down invisible" id="usoulLevel" uid="sl"></span>
								<span class="arrow up invisible" id="dsoulLevel" uid="sl"></span>
							</div>
							<!-- Vitality -->
							<div class="formbox clearfix" uid="vt" idm='stats'>
								<label for="vitality">Vitality</label> 
								<input type="text" maxlength="2" id="bvitality" disabled uid="vt" /> 
								<input type="text" maxlength="2" id="cvitality" tabindex="2" uid="vt" class="bgw"/>
								<span class="arrow down noSelect" id="uvitality" uid="vt"></span>
								<span class="arrow up noSelect" id="dvitality" uid="vt"></span>
							</div>
							<!-- Attunement -->
							<div class="formbox clearfix" uid="at" idm='stats'>
								<label for="attunement">Attunement</label> 
								<input type="text" maxlength="2" id="battunement" disabled uid="at" /> 
								<input type="text" maxlength="2" id="cattunement" tabindex="3" uid="at" class="bgw"/>
								<span class="arrow down noSelect" id="uattunement" uid="at"></span>
								<span class="arrow up noSelect" id="dattunement" uid="at"></span>
							</div>
							<!-- Endurance -->
							<div class="formbox clearfix" uid="en" idm='stats'>
								<label for="endurance">Endurance</label> 
								<input type="text" maxlength="2" id="bendurance" disabled uid="en" /> 
								<input type="text" maxlength="2" id="cendurance" tabindex="4" uid="en" class="bgw"/>
								<span class="arrow down noSelect" id="uendurance" uid="en"></span>
								<span class="arrow up noSelect" id="dendurance" uid="en"></span>
							</div>
							<!-- Strength -->
							<div class="formbox clearfix" uid="st" idm='stats'>
								<label for="strength">Strength</label> 
								<input type="text" maxlength="2" id="bstrength" disabled uid="st" /> 
								<input type="text" maxlength="2" id="cstrength" tabindex="5" uid="st" class="bgw"/>
								<span class="arrow down noSelect" id="ustrength" uid="st"></span>
								<span class="arrow up noSelect" id="dstrength" uid="st"></span>
							</div>
							<!-- Dexterity -->
							<div class="formbox clearfix" uid="dx" idm='stats'>
								<label for="dexterity">Dexterity</label> 
								<input type="text" maxlength="2" id="bdexterity" disabled uid="dx" /> 
								<input type="text" maxlength="2" id="cdexterity" tabindex="6" uid="dx" class="bgw"/>
								<span class="arrow down noSelect" id="udexterity" uid="dx"></span>
								<span class="arrow up noSelect" id="ddexterity" uid="dx"></span>
							</div>
							<!-- Resistance -->
							<div class="formbox clearfix" uid="rs" idm='stats'>
								<label for="resistance">Resistance</label> 
								<input type="text" maxlength="2" id="bresistance" disabled uid="rs" /> 
								<input type="text" maxlength="2" id="cresistance" tabindex="7" uid="rs" class="bgw"/>
								<span class="arrow down noSelect" id="uresistance" uid="rs"></span>
								<span class="arrow up noSelect" id="dresistance" uid="rs"></span>
							</div>
							<!-- Intelligence -->
							<div class="formbox clearfix" uid="in" idm='stats'>
								<label for="intelligence">Intelligence</label> 
								<input type="text" maxlength="2" id="bintelligence" disabled uid="in" /> 
								<input type="text" maxlength="2" id="cintelligence" tabindex="8" uid="in" class="bgw"/>
								<span class="arrow down noSelect" id="uintelligence" uid="in"></span>
								<span class="arrow up noSelect" id="dintelligence" uid="in"></span>
							</div>
							<!-- Faith -->
							<div class="formbox clearfix" uid="ft" idm='stats'>
								<label for="faith">Faith</label> 
								<input type="text" maxlength="2" id="bfaith" disabled uid="ft" /> 
								<input type="text" maxlength="2" id="cfaith" tabindex="9" uid="ft" class="bgw"/>
								<span class="arrow down noSelect" id="ufaith" uid="ft"></span>
								<span class="arrow up noSelect" id="dfaith" uid="ft"></span>
							</div>
							<div class="formbox clearfix" uid="hum">
								<label for="humanity">Humanity</label> 
								<input type="text" maxlength="2" id="chumanity" tabindex="10" uid="hum" value="0" class="bgw"/>
								<span class="arrow down noSelect" id="uhumanity" uid="hum"></span>
								<span class="arrow up noSelect" id="dhumanity" uid="hum"></span>
							</div>
							<hr>
								<div class="soulcost">
									<div class="title"><span>Souls To Next Level</span> <span>Total Souls Spent</span></div>
									<input type="text" maxlength="10" id="csc" tabindex="" uid="csc" readonly />
									<input type="text" maxlength="10" id="cst" tabindex="" uid="cst" readonly />
								</div>
							<hr>
							<div class="formbox clearfix">
								<label for="covenant">Covenant</label> 
								<select id="covenant">
									<option value="0" selected>No Covenant</option>
									<option value="0">Way of White</option>
									<option value="1">Princess Guard</option>
									<option value="3">Blade of the Darkmoon</option>
									<option value="2">Warrior of Sunlight</option>
									<option value="0">Forest Hunter</option>
									<option value="0">Chaos Servant</option>
									<option value="0">Gravelord Servant</option>
									<option value="0">Path of the Dragon</option>
									<option value="0">Darkwraith</option>
								</select>
							</div>
						</div>
					</div>
					<div class="crow exwide">
						<div class="padding bsel">
							<!-- HP -->
							<div class="formbox clearfix" uid="hth">
								<label for="health">HP</label> 
								<input type="text" maxlength="5" id="bhealth" uid="hth" readonly /> 
							</div>
							<!-- Stamina -->
							<div class="formbox clearfix" uid="sta">
								<label for="stamina">Stamina</label> 
								<input type="text" maxlength="4" id="bstamina" uid="sta" readonly /> 
							</div>
							<!-- Equip Load -->
							<div class="formbox clearfix" uid="eqp">
								<label for="equip">Equip Load</label> 
								<input type="text" maxlength="4" id="bequip" uid="eqp" readonly /> 
							</div>
							<div id="loadUsage">0</div>
							<hr class="nomargin">
							<!-- Physical Def -->
							<div class="formbox clearfix" uid="phd">
								<label for="pdef">Physical Def</label> 
								<input type="text" maxlength="8" id="bdef" uid="phd" readonly /> 
							</div>
							<!-- Strike Def -->
							<div class="formbox clearfix offset" uid="shd">
								<label for="pstrike">VS Strike</label> 
								<input type="text" maxlength="8" id="bstrike" uid="shd" readonly /> 
							</div>
							<!-- Slash Def -->
							<div class="formbox clearfix offset" uid="sls">
								<label for="pslash">VS Slash</label> 
								<input type="text" maxlength="8" id="bslash" uid="sls" readonly /> 
							</div>
							<!-- Thrust Def -->
							<div class="formbox clearfix offset" uid="tur">
								<label for="pthrust">VS Thrust</label> 
								<input type="text" maxlength="8" id="bthrust" uid="tur" readonly /> 
							</div>
							<!-- Magig Def -->
							<div class="formbox clearfix" uid="mag">
								<label for="pmagic">Magic Def</label> 
								<input type="text" maxlength="8" id="bmagic" uid="mag" readonly /> 
							</div>
							<!-- Flame Def -->
							<div class="formbox clearfix" uid="fla">
								<label for="pflame">Flame Def</label> 
								<input type="text" maxlength="8" id="bflame" uid="fla" readonly /> 
							</div>
							<!-- Lightning Def -->
							<div class="formbox clearfix" uid="lgh">
								<label for="plight">Lightning Def</label> 
								<input type="text" maxlength="8" id="blight" uid="lgh" readonly /> 
							</div>
							<hr class="nomargin">
						</div>
							<div class="weapons clearfix" style="background-image: url(http://beta.mugenmonkey.com/img/rightleftbg3.png); background-position: center center; background-repeat: no-repeat; background-color: rgb(232, 232, 232);">
								<div class="d"><span class="lh1 blue noSelect bold">LH1</span> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='lh1' typ="normal" class="tip weaponimg" tex="Weapon Upgrade Path"/> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='lh1' typ="wooden" class="tip arrowimg" tex="Select Arrow"/> <span class="lh1i tip">20</span>
									<select id="lh1" class="gear">
										
									</select>
								</div>
								<div class="d right"><span class="rh1i tip">20</span> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='rh1' typ="wooden" class="tip arrowimg" tex="Select Arrow"/> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='rh1' typ="normal" class="tip weaponimg" tex="Weapon Upgrade Path"/> <span class="rh1 blue noSelect bold">RH1</span> 
									<select id="rh1" class="gear">
										
									</select>
								</div>
								<div class="d mtop"><span class="lh2 noSelect bold">LH2</span> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='lh2' typ="normal" class="tip weaponimg" tex="Weapon Upgrade Path"/> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='lh2' typ="wooden" class="tip arrowimg" tex="Select Arrow"/> <span class="lh2i tip">20</span>
									<select id="lh2" class="gear">
										
									</select>
								</div>
								<div class="d right mtop"><span class="rh2i tip">20</span> <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='rh2' typ="wooden" class="tip arrowimg" tex="Select Arrow"/>  <img src="http://static.mugenmonkey.com/img/transparent.png" width="20" height="20" fo='rh2' typ="normal" class="tip weaponimg" tex="Weapon Upgrade Path"/>   <span class="rh2 noSelect bold">RH2</span> 
									<select id="rh2" class="gear">
										
									</select>
								</div>
							</div>
							<div class="pad3 nm15">
							<hr class="nomargin">
								<div class="sh2">
									<input type="checkbox" val="1" id="2hwep" /> <label for="2hwep" class="small">2Hand weps</label> <span class="fright"><span class="small">StamRegen</span> <span class="small faded"><span id="stamin">0</span>/sec (<span id="stamtime">0.0</span> sec to fill)</span></span>
								</div>
								</div>
							
					</div>
					<div class="crow">
						<div class="padding bsel np">
							<!-- Poise -->
							<div class="formbox clearfix" uid="poi">
								<label for="poise">Poise</label> 
								<input type="text" maxlength="4" id="bpoise" uid="poi" readonly /> 
							</div>
							<!-- Bleed Resist -->
							<div class="formbox clearfix" uid="ble">
								<label for="bleed">Bleed Resist</label> 
								<input type="text" maxlength="4" id="bbleed" uid="ble" readonly /> 
							</div>
							<!-- Poison Resist -->
							<div class="formbox clearfix" uid="psn">
								<label for="poison">Poison Resist</label> 
								<input type="text" maxlength="4" id="bposion" uid="psn" readonly /> 
							</div>
							<!-- Curse Resist -->
							<div class="formbox clearfix" uid="cur">
								<label for="curse">Curse Resist</label> 
								<input type="text" maxlength="4" id="bcurse" uid="cur" readonly /> 
							</div>
							<hr class="nomargin">
							<!-- Item Discovery -->
							<div class="formbox clearfix" uid="itd">
								<label for="item">Item Discovery</label> 
								<input type="text" maxlength="4" id="bitem" uid="itd" readonly /> 
							</div>
							<hr class="nomargin">
							<!-- Attunement Slots -->
							<div class="formbox clearfix" uid="ats">
								<label for="attune">Attunement Slots</label> 
								<input type="text" maxlength="4" id="battune" uid="ats" readonly /> 
							</div>
							
							
							<hr class="nomargin">
							<!-- Head Piece -->
							<div class="formbox clearfix big">
								<label for="headgear">Head</label> 
								<select id="headgear" class="gear">
									
								</select>
							</div>
							<!-- Chest Piece -->
							<div class="formbox clearfix big">
								<label for="chestgear">Chest</label> 
								<select id="chestgear" class="gear">
									
								</select>
							</div>
							<!-- Hand Piece -->
							<div class="formbox clearfix big">
								<label for="handgear">Hands</label> 
								<select id="handgear" class="gear">
									
								</select>
							</div>
							<!-- Leg Piece -->
							<div class="formbox clearfix big">
								<label for="leggear">Legs</label> 
								<select id="leggear" class="gear">
									
								</select>
							</div>
							<!-- Ring 1 -->
							<div class="formbox clearfix">
								<label for="ring1">Ring</label> 
								<select id="ring1" class="gear">
									<option value="none1" ind="34" title="img/rings/s/rings25x25.png" snid="-10000px -10000px">No Ring</option>
								</select>
							</div>
							<!-- Ring 2 -->
							<div class="formbox clearfix">
								<label for="ring2">Ring</label> 
								<select id="ring2" class="gear">
									<option value="none2" ind="34" title="img/rings/s/rings25x25.png" snid="-10000px -10000px">No Ring</option>
								</select>
							</div>
							<hr class="nomargin">
							
							
						</div>
						<div class="spellc">
							<div class="effTitle">Active Effects</div>	
							<div id="efcn">
							
							</div>
						</div>
						
					</div>
					<div class="clear"></div>
					<div class="spell2box">
						<select id="spell1" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell2" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell3" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell4" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell5" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell6" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell7" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell8" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell9" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell10" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
						<select id="spell11" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
					
						<select id="spell12" class="spell" disabled='disabled'>
							<option value="0" snd="0" cos='0' spec='0'>No Spell</option>
						</select>
					</div>
					<div class="urltext"><button id="mini" class="tip" tex="Quickly make a tinyURL link">Minify</button>   <button id="savel" class="tip" tex="Publicly Save your Build">Save</button>  Share link <input type="text" id="url" />  
				</div>
				</div>
			</div>
	</form>
		</div>
	</div>
	<?php if(isset($bdes) && !empty($bdes)){
				echo '<div class="desinfo"><div><h2>Notes from the author</h2>';
				echo $bdes;
				echo '</div></div>';
			}
			?>
	<?php include('footer.php'); ?>
	</div>
	<div class="texover"></div>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

	<?php if(isset($base64)){echo '<script type="text/javascript">var b64o = "'.$base64.'";</script>';}else echo '<script type="text/javascript">var b64o = 0;</script>'; ?>
  <script src="js/plugins.js<?php echo $timeasset;?>"></script>
  <script src="js/dat1.js<?php echo $timeasset;?>14423"></script>
  <script src="js/dat2.js<?php echo $timeasset;?>52"></script>
  <script src="js/script.js<?php echo $timeasset;?>982"></script>
  <img src="http://static.mugenmonkey.com/img/loading.gif" width="208" height="13" style="display:none;" />
  <!--[if lte IE 7]><style>.over{height:630px}.crow{height:530px}</style><![endif]-->
</body>
</html>