<?php

$inputFile = 'testForHash.txt';
$text = file_get_contents($inputFile);

function calculateHash($text) {
	return md5($text);
}

$hashTable = [];

// Разбиваем текст на строки (по переводам строки)
$lines = explode("\n", $text);

// Добавляем каждую строку и ее хеш в таблицу
foreach ($lines as $line) {
	$hash = calculateHash($line);
	$hashTable[$hash] = $line;
}

$outputFile = 'outputHashSuperPos.txt';

$outputContent = var_export($hashTable, true);
file_put_contents($outputFile, $outputContent);

echo "Хеш-таблица с наложениями записана в файл $outputFile\n";
