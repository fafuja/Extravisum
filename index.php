<? include "header.php" ?>
<div class="hero" id="main">


<div style="height: 100vh;" id="chekoutindex" class="checkout">

<div class="content">
<div id="indexvideo" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=CF-WUF1UIKQ', mobileFallbackImage:null, opacity:0.4, autoPlay:true, containment:'#chekoutindex', startAt:1, stopAt:0, mute:1, vol:50, optimizeDisplay:true, showControls:false, printUrl:false, loop:true, addRaster:true, quality:'default', ratio:'16/9', realfullscreen:false, gaTrack:false, stopMovieOnBlur:true, remember_last_time:false}"></div>
<!--<div style="background: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)),
	url('../img/background.png') repeat center center;" class="main">

			
			
			
		</div>-->
		</div>
		</div>
		</div>
    </header>
	<div class="main">
	<div class="hero" id="main">
	<div style="height: 100%;" class="checkout">
	<div class="content">
	<div class="main">
	<p class="info">Se divirta com os outros <span class="sip" data-ip="<?php echo $status->ip ?>" data-port="<?php echo $status->port?>">
			<?php// echo $status->players->online?></span> jogadores online no <span class="extravisum.com">extravisum.com</span></p>
	</div>
	</div>
	</div>
	</div>
		
		<div id="games">
			<h2>MINI GAMES</h2>
			<div class="game e">
            <div>
				    
					<h3>SKYWARS</h3>
					<p>Skywars is a gamemode where you start on a floating island with minimal resources. Compete with others or join them and jump to the top of the leaderboards! Difficult challenges are set for you through your sky adventure, complete them for rewards! It takes perseverance, dedication, and effort to get to the top!</p>
				</div>
				<img alt="Skywars" class="gimg a" src="img/skyblock.png">
			</div>
		</div>
		<div id="staff">
			<div class="staff">
				<h2 style="color:white;">NOSSO TIME</h2>
				<div class="staff-team">
					<div id="staffimage">
						<h3><? $pname = "BiohazardH"; echo $pname?></h3>
						<div class="owner">Dono</div>
						<?php $player = json_decode(file_get_contents('https://playerdb.co/api/player/minecraft/'.$pname)); ?>
						<img alt="MyServer Staff Member" src="https://crafatar.com/renders/body/<?php echo $player->data->player->id?>?overlay=true">
					</div>

					<div id="staffimage">
						<h3><? $pname = "Feistt"; echo $pname?></h3>
						<div class="owner">Gerente</div>
						<?php $player = json_decode(file_get_contents('https://playerdb.co/api/player/minecraft/'.$pname)); ?>
						<img alt="MyServer Staff Member" src="https://crafatar.com/renders/body/<?php echo $player->data->player->id?>?overlay=true">
					</div>

					<div id="staffimage">
						<h3><? $pname = "Herogritz"; echo $pname?></h3>
						<div class="manager">Builder</div>
						<?php $player = json_decode(file_get_contents('https://playerdb.co/api/player/minecraft/'.$pname)); ?>
						<img alt="MyServer Staff Member" src="https://crafatar.com/renders/body/<?php echo $player->data->player->id?>?overlay=true">
					</div>

					<div id="staffimage">
						<h3><? $pname = "Fafuja"; echo $pname?></h3>
						<div class="admin">Dev</div>
						<?php $player = json_decode(file_get_contents('https://playerdb.co/api/player/minecraft/'.$pname)); ?>
						<img alt="MyServer Staff Member" src="https://crafatar.com/renders/body/<?php echo $player->data->player->id?>?overlay=true">
					</div>

					
				</div>
			</div>
		</div>
		<?php 
		    $servername = "localhost";
		    $username = "";
		    $password = ""; 
		    $db = "";
		    $canpost = false;
		    
		    $conn = new mysqli($servername, $username, $password, $db);
            		   
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql = "SELECT wp_term_relationships.object_id FROM wp_term_relationships INNER JOIN wp_posts ON wp_term_relationships.object_id = wp_posts.id AND wp_term_relationships.term_taxonomy_id = 9 ORDER BY wp_term_relationships.object_id DESC LIMIT 1";
            
            $result = $conn->query($sql);
            if ($conn->query($sql)->num_rows > 0 ) {
                while($row = $result->fetch_assoc()) {
                    $post_id = $row["object_id"];
                }
                $canpost = true;
                
                $sql2 = "SELECT * FROM wp_posts WHERE wp_posts.id=".$post_id."";
                $result2 = $conn->query($sql2);
                if ($conn->query($sql2)->num_rows > 0 ) {
                    while($row2 = $result2->fetch_assoc()) {
                        $post_title = $row2["post_title"];
                        $post_content = $row2["post_content"];
                        $post_link = $row2["guid"];
                    }
                    
                }
                
            }else{
                $canpost = false;
            }
            
		?>
		
		<div id="announcement">
			<div class="an-img">
				<h2>NOTÍCIAS E ANÚNCIOS</h2>
				<div class="post-content">
				<?php if($canpost): ?>
				<p class="an-t">
					<b style="font-size:40px;"><?php echo $post_title ?></b></br>
					
					<?php 
					    if(strlen($post_content) <= 1500){
					        echo $post_content;
					        echo "</br>";
					   
					    }else{
					        echo substr($post_content, 0, 1500)."...";
					        echo "</br></br>";
					        echo '<a href="'.$post_link.'" class="btn">Continuar Lendo <i class="fas fa-angle-right"></i></a>';
					    }
					?>
			        
				</p>
				</div>
				<?php endif; ?>
			</div>
		</div>
		
	</div>
<? include "footer.php"?>
