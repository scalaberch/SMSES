<script type='text/javascript' src='lib/js/topbar.js'></script>
<div id='right-header'>
			<ul>
				<li><img src='lib/img/icon/clock.png' /></li>
				<li class='text'>
					<span id='myclock'></span>
				</li> 
				<li><img src='lib/img/icon/user.png' /></li>
				<li class='text'>
		<?php
			
			if (isset($_SESSION['user'])){
				$user = $_SESSION['user']->getName();
				echo $user;
			}

		?>		
				</li>
				
				<li>
					<a href='auth/?logout'><img src='lib/img/icon/out.png' /></a>
				</li>
			</ul>
		</div>
	</div>