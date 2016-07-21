<?php 
	require "includes/connect_db.php";
	require 'includes/functions.php';

	$req = $db->query('SELECT id FROM articles');

	$nbre_total_articles = $req->rowCount();

	$nbre_articles_par_page = 4;

	$nbre_pages_max_gauche_et_droite = 4;

	$nbre_pages = ceil($nbre_total_articles / $nbre_articles_par_page);

	if(isset($_GET['page']) && is_numeric($_GET['page'])){
		$page_num = $_GET['page'];
	} else {
		$page_num = 1;
	}

	if($page_num < 1){
		$page_num = 1;
	} else if($page_num > $nbPages) {
		$page_num = $nbPages;
	}

	$limit = 'LIMIT '.($page_num - 1) * $nbre_articles_par_page. ',' . $nbre_articles_par_page;

	//Cette requête sera utilisée plus tard
	$sql = "SELECT id, title, content, DATE_FORMAT(pub_date,'%d/%m/%Y à %Hh%imin%ss') as date FROM articles ORDER BY id DESC $limit";
?> 

<!DOCTYPE html>
<html>
	<head>
		<title>Pagination PHP</title>
		<meta charset="UTF-8" />
		<style>
		body{
			width: 900px;
			margin: 15px auto;
			font-family: "Trebuchet MS", Arial, sans-serif;
		}

		h1{
			background-color: #012;
			text-align: center;
			border-radius: 5px;
			color: #FFF;
			box-shadow: 5px 2px 3px #000;
		}

		a, a:visited{
			color: blue;
		}

		#pagination{
			background-color: #eaeaea;
			padding: 10px;
		}

		#pagination .active{
			background-color: #012;
			color: #FFF;
			padding: 0px 5px 0px 5px;
			border-radius: 20%;
		}

		.post{
			background-color: #c5c5c5;
			margin-bottom: 10px;
			padding-left: 5px;
			border-radius: 4px;
		}
		</style>
	</head>
	<body>
		<h1>Système de Pagination en PHP</h1>
		 <?php 
		 	echo "<p><strong>($nbre_total_articles)</strong> articles au total !<br/>";
			echo "Page <b>$page_num</b> sur <b>$last_page</a>";

			$req = $db->query($sql);

			while($data = $req->fetch()){
				echo '<div class="post"><b>'.$data['title'].'</b><br/>'.$data['content'].'<br/>Publié le '.$data['date'].'</div>';
			}
			
        	if ($nbre_pages > 1 ){ 
        		echo paginate('index.php','?page=',$nbre_pages,$page_num,$nbre_pages_max_gauche_et_droite); 
        	}

			$req->closeCursor();
		?>
	</body>
</html>