<?php

function testDatabaseConnection($config)
{
    // Create a new database connection
    $db = \Config\Database::connect($config);

    // Check if the database connection is successful
    if ($db->connect()) {
        echo 'Database connection successful!';
        $y = 2024;
        $c = 'BOI0044';
        // $conn = createMssqlConnection();
        $sql = "SELECT SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 1 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M1,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 2 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M2,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 3 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M3,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 4 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M4,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 5 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M5,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 6 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M6,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 7 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M7,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 8 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M8,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 9 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M9,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 10 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M10,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 11 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M11,
                CASE
                    WHEN MONTH(SALINHFIL.INH_INVDATE) = 12 THEN SUM(INB_QTY)
                    ELSE 0
                END AS M12
                FROM   SALINHFIL INNER JOIN
                            SALINBFIL ON SALINHFIL.INH_INVNO = SALINBFIL.INB_INVNO
                WHERE YEAR(SALINHFIL.INH_INVDATE) = $y
                GROUP BY SALINBFIL.INB_CUSTCODE, SALINBFIL.INB_CUSTPART,SALINHFIL.INH_INVDATE
                HAVING SALINBFIL.INB_CUSTCODE = '$c'
                ;
                ";

                $query = $db->query($sql);
                // $row = $query->getRow();
                foreach($query->getResult('array') as $row){
                    echo '<pre>';
                    print_r($row);
                }
                die;
    } else {
        echo 'Database connection failed: ' . $db->error();
    }
}

// Usage example:
$config = [
    'DSN'         => '',
    'hostname'    => '192.168.1.2',
    'username'    => 'sa',
    'password'    => '',
    'database'    => 'TBT',
    'DBDriver'    => 'SQLSRV',
    'DBPrefix'    => '',
    'pConnect'    => false,
    'DBDebug'     => (ENVIRONMENT !== 'production'),
    'cacheOn'     => false,
    'cacheDir'    => '',
    'charset'     => 'utf8',
    'DBCollat'    => 'utf8_general_ci',
    'swapPre'     => '',
    'encrypt'     => false,
    'compress'    => false,
    'strictOn'    => false,
    'failover'    => [],
    'port'        => 1433, // Change this to your SQL Server port if needed
];

testDatabaseConnection($config);



?>