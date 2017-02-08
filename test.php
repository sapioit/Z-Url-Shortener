<?php


function test($function_name, $desired_output, ...$function_input){
	/*
	echo json_encode($function_input, JSON_PRETTY_PRINT)."\n";
	echo sizeof($function_input)."\n";
	*/
	if (sizeof($function_input) > 1){
		$function_call = 'return '.$function_name.'(';
		foreach($function_input as $single_input){
			$clean_input = str_replace('\'', '\\\'', $single_input);
			$function_call = $function_call . '"'.$clean_input.'"';
		}
		$function_call = $function_call . ');';
	} else if (sizeof($function_input) == 0) {
		$function_call = 'return '.$function_name.'();';
	} else if (sizeof($function_input) == 1) {
		$function_call = str_replace('\'', '\\\'',$function_input[0]);
		$function_call = 'return '.$function_name.'(\''.$function_call.'\');';
	}
	/*echo $function_call."\n";*/
	$function_output = eval($function_call);
	/*
	$desired_output_ = call_user_func_array
		($function_name, $function_input);
	*/
	$desired_output_ = ($desired_output == null)
		? '`null`' : $desired_output;
	$function_output_ = ($function_output == null)
		? '`null`' : $function_output;
	$function_input_ = (sizeof($function_input) < 1)
		? '`empty`' : $function_input[0];
	// finished debug variables cleaning
	echo '<pre>';
	if($function_output != $desired_output) {
		echo "<b><font color=\"red\">[X]</font> Failed:</b> &#9;".$function_name.
			"\n| wanted: &#9; ".$desired_output_.
			"\n| obtained : &#9; ".$function_output_.
			"\n| input: &#9; ".$function_input_;
	} else {
		echo "<b><font color=\"LimeGreen\">[O]</font> Passed:</b> &#9;".$function_name.
			"\n| obtained: &#9; ".$desired_output_.
			"\n| input: &#9; ".$function_input_;
	}
	echo "\n\n</pre>";
}
