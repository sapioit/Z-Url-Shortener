<?php
require_once("functions.php");
require_once("test.php");
/*$org_str = "http://a.com/\\ceva'alt\"ceva;:<test/>";*/
test('$GLOBALS["crypt"]->enc_html',
	 'http://a.com/\\ceva\'alt"ceva<test/>',
	 '32--\'"<zzz>');
test('$GLOBALS["crypt"]->enc_html',
	 'http://a.com/\\ceva\'alt"ceva<test/>',
	 'http://a.com/\\ceva\'alt"ceva<test/>');
test('$GLOBALS["crypt"]->enc_html',
	 'http://a.com/\ceva&#039;alt&quot;ceva&lt;test/&gt;',
	 'http://a.com/\\ceva\'alt"ceva<test/>');

test('$GLOBALS["crypt"]->enc_html',
	 '32--&#039;&quot;&lt;zzz&gt;',
	 '32--\'"<zzz>');

test('$GLOBALS["crypt"]->enc_html',
	 '32--&#039;&quot;&lt;zzz&gt;',
	 '["32--\'\"<zzz>","aaa"]');

test('$GLOBALS["crypt"]->enc_html',
	 '',
	 '');

test('$GLOBALS["crypt"]->enc_html',
	 '{&quot;0&quot; : &quot;32--&#039;\&quot;&quot;,&quot;1&quot; : &quot;aaa&quot;}',
	 '{"0" : "32--\'\"","1" : "aaa"}');

test('$GLOBALS["crypt"]->enc_html',
	 '32--&#039;&quot;&lt;zzz&gt;',
	<<<'QUOTE'
32--'"<zzz>
QUOTE
);

test('$GLOBALS["crypt"]->enc_html',
	 '{&quot;0&quot; : &quot;32--&#039;\&quot;&quot;,&quot;1&quot; : &quot;aaa&quot;}',
	 <<<'QUOTE'
{"0" : "32--'\"","1" : "aaa"}
QUOTE
);
