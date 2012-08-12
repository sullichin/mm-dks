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
				
		<?php
		$error = '';
		if(isset($_GET['uid']) || isset($_GET['lid'])) {
		$offMod = 50;

		if(isset($_GET['p'])){
			$page = filter_var($_GET['p'],FILTER_VALIDATE_INT);
			if(empty($page))
				$page = 1;
			$offset = ($page - 1) * $offMod;
		} else {
			$page = 1;
			$offset = 0;
		}
		require('inc/contype.php');
		if(isset($_GET['uid'])) {
			$user = $_GET['uid'];
			$nuser = preg_replace('/[^a-zA-Z0-9\-\_ ]/si' , '', $user);
			if($user != $nuser){
				$error .= "<div class='deepred center'>Not a valid username</div>";
			} else {
				$where = "`auth`='{$_GET['uid']}' AND `public`='1'";
			}
			$typ = 'uid='.rawurlencode($user);
		}else if(isset($_GET['lid'])) {
			$list = $_GET['lid'];
			$nlist = preg_replace('/[^a-zA-Z0-9]/si' , '', $list);
			if($list != $nlist){
				$error .= "<div class='deepred center'>Not a valid list id</div>";
			} else {
				$where = "`listid`='{$_GET['lid']}'";
			}
			$typ = 'lid='.$list;
		}
		if(empty($error)){
			$query = mysql_query("SELECT * FROM `saved_builds` WHERE $where ORDER BY `id` DESC LIMIT {$offset}, {$offMod}");
			$count = mysql_num_rows(mysql_query("SELECT * FROM `saved_builds` WHERE $where ORDER BY `id` DESC"));
			
			$maxPage = ceil($count/$offMod);
			$curCount = mysql_num_rows($query);
			// print the link to access each page
			$self = $_SERVER['PHP_SELF'];
			$nav  = '';

			for($pageNum = 1; $pageNum <= $maxPage; $pageNum++)
			{
			   if ($page == $pageNum)
			   {
				  $nav .= " <span class='black'>$page</span> |";
			   }
			   else
			   {
				  $nav .= " <a href=\"/darksouls/share?$typ&p=$pageNum\">$pageNum</a> |";
			   }
			}
			$curNum = ($page - 1) * $offMod;
			$toNums = $curNum.' - '.($curNum + $curCount).' of '.$count;
			if(isset($_GET['uid'])) {
				echo '<h1 class="center white">Showing Builds by '.$_GET['uid'].'</h1>';
			}else if(isset($_GET['lid'])) {
				$listTitle = mysql_fetch_row(mysql_query("SELECT `listtitle` FROM `lists` WHERE $where LIMIT 1"));
				if($listTitle[0]){
					echo '<h1 class="center white">Showing List "'.$listTitle[0].'"</h1>';
				} else {
					echo '<h1 class="center white">List does not exist</h1>';
				}
			}
			echo '<div class="buildList">';
			echo '<div class="kright">'.substr($nav,0,-1).'</div>';
			echo '<div class="buildrow clearfix buildrow2" style="border-bottom: 1px solid #CCCCCC;"><div class="buildtitle faded small">Title</div> <div class="buildauth faded small">Author</div> <div class="builddate faded small">Date</div><div class="clear"></div></div>';
			while($data = mysql_fetch_array($query)){
				echo '<div class="buildrow clearfix"><div class="buildtitle bold"><a href="/darksouls/?c='.$data['ref'].'">'.$data['title'].'</a></div> <div class="buildauth">'.$data['auth'].'</div> <div class="builddate">'.date("M j, Y",strtotime($data['time'])).'</div><div class="clear"></div></div>';
			}
			if(mysql_num_rows($query) == 0){
				echo '<div class="center"><h2>No builds here...</h2></div>';
			}
			echo '<div class="kright">'.substr($nav,0,-1).'</div>';
			echo '</div>';
		} else {
			echo $error."<div class='deepred center'><a href='/darksouls/'>Return</a></div>";
		}
		
	} else {
		echo "<div class='deepred center'>No list or username selected.  No data to retrieve.<br/><a href='/darksouls/'>Return</a></div>";
	}
?>
	
		</div>
	</div>
	
	<?php include('footer.php'); ?>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
<script>
$(document).ready(function(){$('.login').click(function(){$(this).addClass('hover');$('.login_form').addClass('shown');if(!$('.login').hasClass('intent')){$('.login').addClass('intent');$('.login,.login_form').click(function(event){event.stopPropagation();});} else if($('.login').hasClass('intent')){$('.login').removeClass('hover intent');$('.login_form').removeClass('shown');$(document).unbind('click');}$(document).click(function(){$('.login').removeClass('hover intent');$('.login_form').removeClass('shown');$(document).unbind('click');});return false;});});
</script>
</body>
</html>