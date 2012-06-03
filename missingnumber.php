<!DOCTYPE html>
<html>
	<head>
		<title>Missing Number</title>
		<style type="text/css">
			Body {
				font-family: verdana, geneva, sans-serif;
				font-size: 12px;
			}
			.Red {
				color: #FF0000;
				font-weight: bold;
				text-decoration: blink;
			}
		</style>
	</head>
	<body>
		<h2>Source Code</h2>
		<pre>
&lt;?php
	
		/* Missing Number */
		$Input = array();
		//Create an array from 0 to 100.
		for($X=0; $X &lt;= 100; $X++){
			$Input[] = $X;
		}
		//Print the $Input array for validity
		echo '&lt;p&gt;&lt;strong&gt;0-100 Array Creation&lt;/strong&gt;:&lt;/p&gt;';
		echo '&lt;pre&gt;';
		print_r($Input);
		echo '&lt;/pre&gt;';
		//Just for kicks, use array_rand instead of mt_rand
		$ArrayRand 		= array_rand($Input, 1);
		echo '&lt;br /&gt;&lt;strong&gt;Random Number&lt;/strong&gt;: '.$ArrayRand;
		//Replace the random number that was determined with null.
		$ReplaceArray 		= array($ArrayRand =&gt; '');
		$Input 			= array_replace($Input, $ReplaceArray);
		//Print the $Input array for validity
		echo '&lt;pre&gt;';
		print_r($Input);
		echo '&lt;/pre&gt;';
		//Set the new counter
		$Y = 0;
		//Loop through each element, if one doesn't have a a numeric value, return it as the missing number.
		foreach($Input as $In){
			if(!preg_match('/^\d+$/', $In)){
				$MissingNumber = $Y;
				break;
			}
			$Y++;
		}
		
		echo '&lt;p&gt;&lt;strong&gt;The Missing Number Is&lt;/strong&gt;: '.$MissingNumber;

?&gt;
		</pre>
	<h2>Execution</h2>
	<?php
	
		/* Missing Number */
		$Input = array();
		//Create an array from 0 to 100.
		for($X=0; $X <= 100; $X++){
			$Input[] = $X;
		}
		//Print the $Input array for validity
		echo '<p><strong>0-100 Array Creation</strong>:</p>';
		echo '<pre>';
		print_r($Input);
		echo '</pre>';
		//Just for kicks, use array_rand instead of mt_rand
		$ArrayRand 		= array_rand($Input, 1);
		echo '<br /><strong>Random Number</strong>: '.$ArrayRand;
		//Replace the random number that was determined with null.
		$ReplaceArray 	= array($ArrayRand => '<span class="Red">Missing Number!</span>');
		$Input 			= array_replace($Input, $ReplaceArray);
		//Print the $Input array for validity
		echo '<pre>';
		print_r($Input);
		echo '</pre>';
		//Set the new counter
		$Y = 0;
		//Loop through each element, if one doesn't have a a numeric value, return it as the missing number.
		foreach($Input as $In){
			if(!preg_match('/^\d+$/', $In)){
				$MissingNumber = $Y;
				break;
			}
			$Y++;
		}
		
		echo '<p><strong>The Missing Number Is</strong>: '.$MissingNumber;

	?>
	<p>Thanks for checking out my Missing Number script!</p>
	</body>
</html>