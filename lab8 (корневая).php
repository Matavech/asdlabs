<?php
function rootSort($arr) {
	$maxValue = max($arr);
	$minValue = min($arr);
	$range = $maxValue - $minValue + 1;

	// Создаем массив для подсчета вхождений каждого элемента
	$count = array_fill(0, $range, 0);

	// Подсчитываем вхождения элементов
	foreach ($arr as $element) {
		$count[$element - $minValue]++;
	}

	// Строим отсортированный массив на основе подсчетов
	$sortedArray = [];
	for ($i = 0; $i < $range; $i++) {
		while ($count[$i] > 0) {
			$sortedArray[] = $i + $minValue;
			$count[$i]--;
		}
	}

	return $sortedArray;
}


$arr = [4, 2, 2, 8, 3, 3, 1];
$sortedArray = rootSort($arr);
echo "Отсортированный массив: " . implode(", ", $sortedArray);
