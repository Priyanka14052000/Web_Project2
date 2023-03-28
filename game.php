<?php 
session_start();

$_SESSION['dice']= '0' ;
function roll_dice()
{ $dice=rand(1, 6);
$_SESSION['dice']= $dice ;
return $dice;
     
}
$player_turn=isset($_POST["player_turn"])?$_POST["player_turn"]:1;

    $is_initial_load = true;
	  if ( isset( $_POST[ "user_turn" ] ) ) {
		if ($player_turn==1){
		   $player_turn=2;
		 
	$players  = [
            [ "name" => $_POST[ "player_1_name" ], "score" => roll_dice()+$_SESSION['players'][ 0 ][ "score" ]],
            [ "name" => $_POST[ "player_2_name" ], "score" => $_SESSION['players'][ 1 ][ "score" ]]
        ];		
	$level = $_POST["levels"];

 if( $players[ 0 ][ "score" ]>100)
 {$players  = [
            [ "name" => $_POST[ "player_1_name" ], "score" => +$_SESSION['players'][ 0 ][ "score" ]],
            [ "name" => $_POST[ "player_2_name" ], "score" => $_SESSION['players'][ 1 ][ "score" ]]
        ];	
 }
 
	 
$_SESSION['players']= $players ;	

	
	   }
	   else{
		   $player_turn=1;
		   
		   $players  = [
            [ "name" => $_POST[ "player_1_name" ], "score" => $_SESSION['players'][ 0 ][ "score" ] ],
            [ "name" => $_POST[ "player_2_name" ], "score" => roll_dice()+$_SESSION['players'][ 1 ][ "score" ]],
        ];	
		$level = $_POST["levels"];
		if( $players[ 1 ][ "score" ]>100)
 {$players  = [
            [ "name" => $_POST[ "player_1_name" ], "score" => +$_SESSION['players'][ 0 ][ "score" ]],
            [ "name" => $_POST[ "player_2_name" ], "score" => $_SESSION['players'][ 1 ][ "score" ]]
        ];	
 }
		$_SESSION['players']= $players ;
	   }
	   
         
        $is_initial_load = false;
    }
	
	else  if ( isset( $players ) ) 
	{
		
		$players[ $player_turn - 1 ][ "score" ] += $players[ $player_turn - 1 ][ "score" ];
		
	}
		else
     if ( isset( $_GET[ "start" ] ) ) {
        $players           = [
            [ "name" => $_GET[ "player_1_name" ], "score" => 0 ],
            [ "name" => $_GET[ "player_2_name" ], "score" => 0 ],
        ];
		$level = $_GET[ "levels"];
        $is_initial_load   = false;
		$_SESSION['players']= $players ;
        
    } 
	
	
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>The Dice Game</title>
        <link rel="stylesheet" href="css/game.css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
		<link rel="icon" type="image/x-icon" href="img/dice.png">

</head>
<body>  
<nav>
	<div class="logo"> <h1 style="font-size: 20px;"> Menu </h1> </div>
	<div class="menu">
		<a href="index.html" style="font-size: ">Home</a>
		<a href="about.html">About</a>
		<a href="game.php">Game</a>
		<a href="summary.html">Summary</a>

	</div>
</nav>
        <?php if ( ! $is_initial_load ) : ?>
      
            <form id="main_game_form" action="game.php" method="post">
			<div id="game-title">
						<h3>The Dice Game</h3>
					<h1>ROLL YOUR LUCK</h1>
					<h4>"Roll and Race"</h4></div>
                <div id="game-field">
                <?php
                $rows = 10; // define number of rows
$cols = 10;// define number of columns
$count=100;
echo "<table border='1' align='center'>";

for($tr=1;$tr<=$rows;$tr++){

    echo "<tr >";
        for($td=1;$td<=$cols;$td++){
	          
		   
		   if($count% $level==0)
			{
				echo "<td  style='width:80px;' id='danger'>".$count."</td>";
			 if($count==$_SESSION['players'][ 0 ][ "score" ])
				{
					
				 $players  = [
            [ "name" => $_POST[ "player_1_name" ], "score" => $_SESSION['players'][ 0 ][ "score" ]- (11 - $level)],
            [ "name" => $_POST[ "player_2_name" ], "score" => $_SESSION['players'][ 1 ][ "score" ]]
        ];
		$level = $_POST[ "levels"];

		$_SESSION['players']= $players ;
		$_SESSION['dice']= $_SESSION['dice'].", was in DANGER zone (".$count.") <br> Score of  <span> ". $players[ 0][ "name" ]."  </span> was dedicted by ". (11 - $level).".";
			} 
			if($count==$_SESSION['players'][ 1 ][ "score" ])
				{
				 $players  = [
            [ "name" => $_POST[ "player_1_name" ], "score" => $_SESSION['players'][ 0 ][ "score" ]],
            [ "name" => $_POST[ "player_2_name" ], "score" => $_SESSION['players'][ 1 ][ "score" ]-(11 - $level)]
        ];
		$level = $_POST[ "levels"];
		$_SESSION['players']= $players ;
		$_SESSION['dice']= $_SESSION['dice'].",  was in DANGER zone (".$count.") <br> Score of  <span> ". $players[1][ "name" ]."  </span> was dedicted by  ". (11 - $level).".";
			}
			}
			 else
			 {				 
				 if($count==$_SESSION['players'][ 0 ][ "score" ] && $count==$_SESSION['players'][ 1 ][ "score" ] )
					echo "<td width='80px' height='40px' align='center' bgcolor='yellow'>".$_SESSION['players'][ 0 ][ "name" ]."\n".$_SESSION['players'][ 1 ][ "name" ] ."</td>";
		   else  if($count==$_SESSION['players'][ 0 ][ "score" ])
		   {
				 if($count==100)
			{ $_SESSION['dice']=$_SESSION['dice'].",".$_SESSION['players'][ 0 ][ "name" ]."  WON";}
		echo "<td width='80px' height='40px' align='center'  bgcolor='#1E90FF'>".$_SESSION['players'][ 0 ][ "name" ]."</td>"; 
		   }
			 else if($count==$_SESSION['players'][ 1 ][ "score" ])
		   { 
	   
				 if($count==100)
			{ $_SESSION['dice']=$_SESSION['dice']." ,".$_SESSION['players'][ 1 ][ "name" ]."  Won";}
			
	   
	   echo "<td width='80px' height='40px' align='center' bgcolor='#90EE90'>".$_SESSION['players'][ 1 ][ "name" ]."</td>";
		   }else				 
               echo "<td  class='safe' width='80px' height='40px' align='center'>".$count."</td>";
			 }
            $count--;
			
        }
    echo "</tr>";
}



echo "</table>";
                ?>
                </div>
                <?php
                   

                 
                    if ( isset( $players ) ) {
                        echo "<input hidden name=\"player_1_name\" type=\"text\" value=\"" . $players[ 0 ][ "name" ] . "\">";
                        echo "<input hidden name=\"player_2_name\" type=\"text\" value=\"" . $players[ 1 ][ "name" ] . "\">";
                        echo "<input hidden name=\"player_1_score\" type=\"text\" value=\"" . $players[ 0 ][ "score" ] . "\">";
                        echo "<input hidden name=\"player_2_score\" type=\"text\" value=\"" . $players[ 1 ][ "score" ] . "\">";
                        echo "<input hidden name=\"levels\" type=\"text\" value=\"" . $level .  "\">";

                    }
                    
                    echo "<input hidden name=\"player_turn\" type=\"text\" value=\"$player_turn\">";
                ?>

                <div id="player_1_gui">
                    <?php
                        $player_being_configured = 1;
                        include "player_gui.php" ?>
                </div>
				
                <div id="dice_result">
									

                    <h1 id="show"><?php if ( isset( $_SESSION['dice'] ) )
						  if( $players[0][ "score" ]!= 0 or  $players[1][ "score" ]!= 0  ){
						if ($player_turn==1){
                            echo  "<span>".$players[1][ "name" ]." </span> rolled ".$_SESSION['dice'];
						   }else{
						   echo "<span>". $players[0][ "name" ]." </span>  rolled ".$_SESSION['dice'];
						   }
						  }else{
						   echo 'roll the dice';

						  }
                         ?></h1>
                </div>
                <div id="player_2_gui">
                    <?php
                        $player_being_configured = 2;
                        include "player_gui.php" ?>
                </div>
				
            </form>
				<div id="level">
					<h2>Level of Difficulty </h2>
					<h1><?php if ($level == 8) {
							echo "Easy";
					}else if ($level == 7) {
							echo "Normal";
					}else if ($level == 6) {
							echo "Hard";
					}else if ($level == 5) {
							echo "Very Hard";	
					}else if ($level == 4) {
							echo "Legend";						
					}else if ($level == 3) {
							echo "I Feel Lucky";
					}else {
						echo "Unkown";
					}							
					
					?>
					</h1>
				</div>
            
        <?php else: ?>
            <div id="start-form-wrapper">
            <div id="game-title">
					<h3>The Dice Game</h3>
					<h1>ROLL YOUR LUCK</h1>
					<h4>"Roll and Race"</h4>
					</div>
                <form id="start-form" action="game.php" method="get">
                   
                    
                    <br>				
					<p> Please enter names of the players.</p>
                    <div id="names">
                        <input type="text" required name="player_1_name" placeholder="Player 1 Name" />
                        <input type="text" required name="player_2_name" placeholder="Player 2 Name" />
                   </div>
                    <br>
					<div id="level-options" >
					<label>Choose level of hardness:</label>
						  <select id="level-options-select" name="levels">
							<option selected value="8">Easy</option>
							<option value="7">Normal</option>
							<option value="6">Hard</option>
							<option value="5">Very Hard</option>
							<option value="4">Legend</option>
							<option value="3">I Feel Lucky</option>

						  </select>
					</div>
                    <br>    
					<br>
                    <button type="submit" id="button-start" value="Start" name="start"> START</button>
                
                </form>
                                                                   </div>
   
           
        <?php endif; ?>
    </body>
</html>
