<?php

$host = '127.0.0.1';
$db   = 'govt_job_portal';
$user = 'jobone';
$pass = 'dMBPKNILBtae612jFcLxNQksAINFO';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$competitors = [
    'freejobalert.com',
    'freejobalert',
    'sarkariresult.com',
    'sarkariresult',
    'sarakariresult.com',
    'sarakariresult',
    'rojgarresult.com',
    'rojgarresult'
];

$columns = ['content', 'meta_title', 'meta_description', 'meta_keywords'];

echo "=== COMPETITOR MENTIONS FOUND ===\n";

$totalUpdated = 0;

foreach ($columns as $col) {
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM posts LIKE '$col'");
    if ($stmt->rowCount() == 0) continue;

    $queryParts = [];
    $params = [];
    foreach ($competitors as $index => $comp) {
        $queryParts[] = "$col LIKE ?";
        $params[] = "%$comp%";
    }
    
    $sql = "SELECT id FROM posts WHERE " . implode(" OR ", $queryParts);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
    
    if (count($results) > 0) {
        echo "Found " . count($results) . " posts with competitors in '$col' column.\n";
        
        // Let's replace them!
        $updateSql = "UPDATE posts SET $col = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE($col, 'freejobalert.com', 'JobOne.in'), 'freejobalert', 'JobOne'), 'sarkariresult.com', 'JobOne.in'), 'sarkariresult', 'JobOne'), 'sarakariresult.com', 'JobOne.in'), 'sarakariresult', 'JobOne') WHERE " . implode(" OR ", $queryParts);
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute($params);
        $totalUpdated += count($results);
        echo " -> Cleaned $col column.\n";
    }
}

echo "\nTotal posts cleaned: $totalUpdated\n";
