<?php
include_once "connect.php";

if (!empty($_REQUEST['query'])) $_query = $_REQUEST['query'];

?>
<form action="./view.query.php" method="post">
	<input type="text" name="query" value="<?php echo  $_query;?>"   size="100">
	<button type="submit">query</button>
</form>
<?php

if (empty($_query)) exit;

$sql = $_query;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>
<table border='1'>
<tr>
<td>ID</td>
<td>BOARD_DATE</td>
<td>BOARD_TIME</td>
<td>BOARD_IP</td>
<td>MB</td>
<td>SB</td>
<td>T1</td>
<td>T2</td>
<td>T3</td>
<td>T4</td>
<td>H1</td>
<td>WATER</td>
<td>w1</td>
<td>w2</td>
<td>E1</td>
</tr>

<?php
while($row = mysqli_fetch_array($result)) {
	echo "<tr>";
	echo "<td>".$row['ID']."</td>".
	     "<td>".$row['BOARD_DATE']."</td>".

	     "<td>".$row['BOARD_TIME']."</td>".

	     "<td>".$row['BOARD_IP']."</td>".

	     "<td>".$row['MB']."</td>".

	     "<td>".$row['SB']."</td>".

	     "<td>".$row['T1']."</td>".

	     "<td>".$row['T2']."</td>".

	     "<td>".$row['T3']."</td>".

	     "<td>".$row['T4']."</td>".

	     "<td>".$row['H1']."</td>".

	     "<td>".$row['WATER']."</td>".

	     "<td>".$row['w1']."</td>".

	     "<td>".$row['w2']."</td>".

	     "<td>".$row['E1']."</td>";
	echo "</tr>";
}
?>
</table>
