<!DOCTYPE html>
<html>
	<head>
		<title>Reverse the String</title>
		<style type="text/css">
			Body {
				font-family: verdana, geneva, sans-serif;
				font-size: 12px;
			}
		</style>
	</head>
	<body>
		<h2>Source Code</h2>
		<pre>
&lt;?php
	
	/* Reverse the String */
	$String 	= "Foo Baz Bar";
	echo '&lt;p&gt;Normal: '.$String.'&lt;/p&gt;';
		
	//View the Exploded String
	$ExplodedString = explode(' ', $String);
	echo '&lt;pre&gt;';
	print_r($ExplodedString);
	echo '&lt;/pre&gt;';
		
	//Reverse the array
	$ReverseArray	= array_reverse($ExplodedString);
	echo '&lt;pre&gt;';
	print_r($ReverseArray);
	echo '&lt;/pre&gt;';
		
	//Set the end variable
	$Text = '';
		
	//Loop through the array
	foreach($ReverseArray as $Rev){
		$Text .= $Rev.' ';
	}
		
	//End Result
	echo '&lt;p&gt;Reversed: '.$Text.'&lt;/p&gt;';

?&gt;
		</pre>
	<h2>Execution</h2>
	<?php
	
		/* Reverse the String */
		$String 		= "Foo Baz Bar";
		echo '<p>Normal: '.$String.'</p>';
		
		//View the Exploded String
		$ExplodedString = explode(' ', $String);
		echo '<pre>';
		print_r($ExplodedString);
		echo '</pre>';
		
		//Reverse the array
		$ReverseArray	= array_reverse($ExplodedString);
		echo '<pre>';
		print_r($ReverseArray);
		echo '</pre>';
		
		//Set the end variable
		$Text = '';
		
		//Loop through the array
		foreach($ReverseArray as $Rev){
			$Text .= $Rev.' ';
		}
		
		//End Result
		echo '<p>Reversed: '.$Text.'</p>';

	?>
	<p>Thanks for checking out my Reverse the String script!</p>
	</body>
</html>