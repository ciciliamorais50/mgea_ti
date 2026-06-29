<?php
$conn = mysqli_connect('localhost', 'root', '', 'sgti');
if (!$conn) { echo "CONNFAIL\n"; exit(1); }
$result = mysqli_query($conn, 'SELECT COUNT(*) FROM chamados');
$row = mysqli_fetch_row($result); echo "total_chamados: " . $row[0] . "\n";
$result = mysqli_query($conn, 'SHOW COLUMNS FROM chamados');
while ($row = mysqli_fetch_row($result)) { echo implode(' | ', $row) . "\n"; }
?>