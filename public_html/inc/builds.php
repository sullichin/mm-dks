<?php
	$offMod = 100;

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
	if(isset($_COOKIE['user']) && isset($_COOKIE['token'])){
		$toekn = $_COOKIE['token'];
	} else {
		$toekn = false;
	}
	if($toekn) {
		$query = mysql_query("SELECT `saved_builds`.*,`favorites`.`refid`,`favorites`.`nameid` FROM `saved_builds` LEFT JOIN `favorites` ON `saved_builds`.`ref` = `favorites`.`refid` AND `favorites`.`nameid` = '$toekn' WHERE `saved_builds`.`public`='1' ORDER BY `saved_builds`.`id` DESC LIMIT {$offset}, {$offMod}") or die(mysql_error());
	
	} else {
		$query = mysql_query("SELECT `saved_builds`.* FROM `saved_builds` WHERE `saved_builds`.`public`='1' ORDER BY `saved_builds`.`id` DESC LIMIT {$offset}, {$offMod}") or die(mysql_error());
	}
	$count = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM `saved_builds` WHERE `public`='1' ORDER BY `id` DESC"));
	$count = $count[0];
	
	$maxPage = ceil($count/$offMod);
	$curCount = mysql_num_rows($query);
	// print the link to access each page
	$self = $_SERVER['PHP_SELF'];
	$nav  = '';

	/*for($pageNum = 1; $pageNum <= $maxPage; $pageNum++)
	{
	   if ($page == $pageNum)
	   {
		  $nav .= " <span class='black'>$page</span> |";
	   }
	   else
	   {
		  $nav .= " <a href=\"/darksouls/builds?p=$pageNum\">$pageNum</a> |";
	   }
	}*/
	if($page == 1) {
		$nav .= " <span class='black'>$page</span> |";
		for($i = 2; $i <= 15; $i++){
			$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
		}
		$nav .= " ... <a href=\"/darksouls/builds?p=$maxPage\">$maxPage</a> |";
	}else {
		if($page >= 10){
			$nav .= " <a href=\"/darksouls/builds?p=1\">1</a> ... | ";
			if($page == $maxPage) {
				for($i = $page - 12; $i < $page; $i++){
					$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
				}
			} else if($page >= $maxPage - 5) {
				for($i = $page - (12 + ($page - $maxPage)); $i < $page; $i++){
					$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
				}
			} else {
				for($i = $page - 6; $i < $page; $i++){
					$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
				}
			}
			$nav .= " <span class='black'>$page</span> |";
			for($i = $page + 1; $i < $page + 7; $i++){
				if($i <= $maxPage)
				$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
			}
			if($i == $maxPage)
				$nav .= " <a href=\"/darksouls/builds?p=$maxPage\">$maxPage</a> |";
			if($i < $maxPage)
				$nav .= " ... <a href=\"/darksouls/builds?p=$maxPage\">$maxPage</a> |";
		} else {
			if($page > 1 && $page < 10) {
				for($i = 1; $i < $page; $i++){ 
					
					$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
				}
				$nav .= " <span class='black'>$page</span> |";
				for($i = $i + 1; $i < $page + 7 + (9 - $page); $i++){ 
					$nav .= " <a href=\"/darksouls/builds?p=$i\">$i</a> |";
				}
				$nav .= " ... <a href=\"/darksouls/builds?p=$maxPage\">$maxPage</a> |";
			}
		}
	}
	$curNum = ($page - 1) * $offMod;
	$toNums = $curNum.' - '.($curNum + $curCount).' of '.$count;
	echo '<h1 class="center white">Saved Builds</h1>';
	echo '<div class="buildList">';
	echo '<div class="kright">'.substr($nav,0,-1).'</div>';
	echo '<div class="buildrow clearfix buildrow2" style="border-bottom: 1px solid #CCCCCC;"><div class="buildtitle faded small">Title</div> <div class="buildauth faded small">Author</div> <div class="builddate faded small">Date</div><div class="clear"></div></div>';
	while($data = mysql_fetch_array($query)){
		echo '<div class="buildrow clearfix"><div class="buildtitle bold"><a href="/darksouls/?c='.$data['ref'].'">'.$data['title'].'</a></div> <div class="buildauth">';
			$user = $data['auth'];
			$nuser = preg_replace('/[^a-zA-Z0-9\-\_ ]/si' , '', $user);
			if($user != $nuser || $user == 'Anonymous'){
				echo $data['auth'];
			} else {
				if($user == 'nemesismonkey')
					echo "<a href='/darksouls/share?uid=nemesismonkey' style='color:#dd5b5b;font-weight:bold;'>nemesismonkey</a>";
				else
					echo "<a href='/darksouls/share?uid=".rawurlencode($data['auth'])."'>".$data['auth'].'</a>';
			}
		echo '</div> <div class="builddate">'.date("M j, Y",strtotime($data['time'])).'</div><div class="clear"></div>';
		if($data['soullevel'] != 0){
			echo '<div class="small buildtitle">SL <strong>'.$data['soullevel'].'</strong> (<strong>'.$data['vitality'].'</strong>/<strong>'.$data['attunement'].'</strong>/<strong>'.$data['endurance'].'</strong>/<strong>'.$data['strength'].'</strong>/<strong>'.$data['dexterity'].'</strong>/<strong>'.$data['resistance'].'</strong>/<strong>'.$data['inteligence'].'</strong>/<strong>'.$data['faith'].'</strong>)</div>';
			echo '<div class="small buildauth faded"><span class="kvot black n'.$data['ref'].'">'.$data['totalof'].'</span> points | <div class="votearrows vup" title="'.$data['ref'].'"></div> <div class="votearrows vdo" title="'.$data['ref'].'"></div> | <span class="nvot n'.$data['ref'].'">'.$data['numvotes'].'</span> votes <span class="tvut black hidden n'.$data['ref'].'">Already Voted</span></div>';
			if(isset($_COOKIE['user']) && isset($_COOKIE['token'])){
				if(!empty($data['refid'])){
					echo '<div class="builddate small faded">favorited</div>'; // [<A href="#'.$data['ref'].'" class="rf" rel="nofollow">remove</a>]</div>';
				} else {
					echo '<div class="builddate small faded">[<A href="#'.$data['ref'].'" class="favorites" rel="nofollow">favorite</a>]</div>';
				}
			}
		}
		echo '</div>';
	}
	if(mysql_num_rows($query) == 0){
		echo '<div class="center"><h2>No builds here...</h2></div>';
	}
	echo '<div class="kright">'.substr($nav,0,-1).'</div>';
	echo '</div>';
?>