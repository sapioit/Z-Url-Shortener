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
