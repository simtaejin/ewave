<?php

if (!empty($_REQUEST['txt'])) $_txt = $_REQUEST['txt'];

if ($_txt) {
	file_put_contents("control.txt", "");


	$fp = fopen("control.txt", "w");

	// 파일에 내용 출력
	fwrite($fp, $_txt);

	// 파일 닫기
	fclose($fp);
	echo $_txt;
	exit;
}

?>
<form action="./file.clear.php" method="post">
	<input type="text" name="txt" value="<?php echo  $_txt;?>"   size="100">
	<button type="submit">txt</button>
</form>

