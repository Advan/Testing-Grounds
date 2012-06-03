<!DOCTYPE html>
<html>
	<head>
		<title>Ye Olde' Fizz Buzzith Testith</title>
		<style type="text/css">
			Body {
				font-family: verdana, geneva, sans-serif;
				font-size: 12px;
			}
			
			#FizzBuzz .Box {
				color: #FFFFFF;
				margin-bottom: 20px;
				margin-top: 20px;
				border-radius: 5px;
				width: 250px;
				padding: 5px 15px;
			}
			
			#FizzBuzz .Box:hover {
				transition:width 1s;
				transition-property: width;
				transition-duration: 1s;
				transition-timing-function: ease;
				-moz-transition: width 1s;
				-moz-transition-duration: 1s;
				-moz-transition-timing-function: ease;
				-webkit-transition-property: width;
				-webkit-transition-duration: 1s;
				-webkit-transition-timing-function: ease;
				-o-transition-property: width;
				-o-transition-duration: 1s;
				-o-transition-timing-function: ease;
			}
			
			#FizzBuzz .F {
				background-color: #FF0000;
			}
			
			#FizzBuzz .F:hover {
				width: 300px;
			}
			
			#FizzBuzz .B {
				background-color: #3232CD;
			}
			
			#FizzBuzz .B:hover {
				width: 300px;
			}
			
			#FizzBuzz .FB {
				background-color: #A200FF;
			}
			
			#FizzBuzz .FB:hover {
				width: 500px;
			}
			
			#FizzBuzz .N {
				background-color: #808080;
			}
			
			#FizzBuzz .N:hover {
				width: 25px;
			}
		</style>
	</head>
	<body>
		<h2>Source Code</h2>
		<pre>
&lt;?php
	
	/* FizzBuzz! */
	for($X=1; $X <= 100; $X++){
		//Multiples of 3
		if($X % 3 == 0 && $X % 5 != 0){
			echo '&lt;p class="Box F">['.$X.'] Fizz - Multiples of 3&lt;/p&gt;';
		}
		//Multiples of 5
		elseif($X % 5 == 0 && $X % 3 != 0){
			echo '&lt;p class="Box B"&gt;['.$X.'] Buzz - Multiples of 5&lt;/p&gt;';
		}
		//Multiples of 3 and 5
		elseif($X % 5 == 0 && $X % 3 == 0){
			echo '&lt;p class="Box FB"&gt;['.$X.'] FizzBuzz - Multiples of 3 and 5&lt;/p&gt;';
		}
		//All other integers
		else {
			echo '&lt;p class="Box N"&gt;'.$X.'&lt;/p&gt;';
		}
	}

?&gt;
		</pre>
	<h2>Execution</h2>
	<div id="FizzBuzz">
	<?php
	
		/* FizzBuzz! */
		for($X=1; $X <= 100; $X++){
			//Multiples of 3
			if($X % 3 == 0 && $X % 5 != 0){
				echo '<p class="Box F">['.$X.'] Fizz - Multiples of 3</p>';
			}
			//Multiples of 5
			elseif($X % 5 == 0 && $X % 3 != 0){
				echo '<p class="Box B">['.$X.'] Buzz - Multiples of 5</p>';
			}
			//Multiples of 3 and 5
			elseif($X % 5 == 0 && $X % 3 == 0){
				echo '<p class="Box FB">['.$X.'] FizzBuzz - Multiples of 3 and 5</p>';
			}
			//All other integers
			else {
				echo '<p class="Box N">'.$X.'</p>';
			}
		}

	?>
	</div>
	<p>Thanks for checking out my FizzBuzz script!</p>
	</body>
</html>