<?php
function test_clean($input){
	return "<<<'TESTING'\n" . $input . "\nTESTING\n";
}
function test($function_name, $desired_output, $function_input){
	/*
	echo json_encode($function_input, JSON_PRETTY_PRINT)."\n";
	echo sizeof($function_input)."\n";
	*/
	if (gettype(json_decode($function_input)) !== 'array'){
		$function_call = 'return '.$function_name."( ".test_clean($function_input)." );";
	} else {
		$function_input = json_decode($function_input);
		$nr_inputs = sizeof($function_input);
		if ($nr_inputs < 1)
			$function_call = 'return '.$function_name.'();';
		else {
			$function_call = 'return '.$function_name.'(';
			$counter = 1;
			foreach ($function_input as $input){
				$function_call = $function_call . test_clean($input);
				if($counter++ != $nr_inputs)
					$function_call = $function_call . ",";
			}
			$function_call = $function_call .");\n";
		}
	}
	/*echo "<pre>".$function_call."</pre>\n";*/
	$function_output = eval($function_call);
	/*
	$desired_output_ = call_user_func_array
		($function_name, $function_input);
	*/
	test_echo($desired_output, $function_output, $function_input, $function_name);
}

function test_echo($desired_output, $function_output, $function_input, $function_name){
	/*echo gettype($function_input);*/
	if (gettype($function_input) !== 'array' &&
		gettype(json_decode($function_input)) === 'array')
		$function_input = json_decode($function_input);
	$desired_output_ = ($desired_output == null)
		? '`null`' : $desired_output;
	$function_output_ = ($function_output == null)
		? '`null`' : $function_output;
	/*$function_input_ = (sizeof($function_input) < 1)
		? '`empty`' : $function_input[0];*/
	// finished debug variables cleaning
	echo '<pre>';
	if(gettype($function_input)==='array')
		$function_input = json_encode($function_input, JSON_PRETTY_PRINT);

	if($function_output === $desired_output) {
		echo "<b><font color=\"LimeGreen\">[O]</font> Passed:</b> &#9;".$function_name.
			"\n| obtained: &#9; ".$desired_output_.
			"\n| input: &#9; ".$function_input;
	} else {
		echo "<b><font color=\"Red\">[X]</font> Failed:</b> &#9;".$function_name.
			"\n| wanted: &#9; ".$desired_output_.
			"\n| obtained : &#9; ".$function_output_.
			"\n| input: &#9; ".$function_input;
	}
	echo "\n\n</pre>";
}
