<?php

function radixSort(array &$arr) {
	$max = max($arr);
	$numDigits = strlen((string)$max);

	for ($i = 0; $i < $numDigits; $i++) {
		$buckets = array_fill(0, 10, []);

		foreach ($arr as $value) {
			$digit = ($value / pow(10, $i)) % 10;
			$buckets[$digit][] = $value;
		}

		$arr = [];
		foreach ($buckets as $bucket) {
			$arr = array_merge($arr, $bucket);
		}
	}
}

// Пример использования
$array = [170, 45, 75, 90, 802, 24, 2, 66];
radixSort($array);

echo "Отсортированный массив: " . implode(", ", $array);
