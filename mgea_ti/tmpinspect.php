<?php
$conn = mysqli_connect('localhost', 'root', '', 'sgti');
if (!$conn) {
    echo "CONNFAIL\n";
    exit(1);
}
$result = mysqli_query($conn, 'SHOW TABLES');
while ($row = mysqli_fetch_row($result)) {
    echo $row[0] . "\n";
}
echo "---\n";
$result = mysqli_query($conn, 'SELECT idItemCategoria, nomeItem FROM itens_categoria LIMIT 10');
while ($row = mysqli_fetch_row($result)) {
    echo implode(' | ', $row) . "\n";
}
echo "---\n";
$result = mysqli_query($conn, 'SHOW COLUMNS FROM chamados');
while ($row = mysqli_fetch_row($result)) {
    echo implode(' | ', $row) . "\n";
}
?>