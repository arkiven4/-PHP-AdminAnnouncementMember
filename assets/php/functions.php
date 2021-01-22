<?php 
//$conn = mysqli_connect('mysql.lesterlive.com', 'devone', 'CodeByDevone0912!', 'devone_mbr');
$conn = mysqli_connect('localhost', 'root', '', 'devone_mbr');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function randomString()
{
    return md5(rand(100, 200));
}
?>