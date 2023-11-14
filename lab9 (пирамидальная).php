<?php

function heapSort(&$arr)
{
	$n = count($arr);

	// Строим max-кучу
	for ($i = ($n / 2) - 1; $i >= 0; $i--) {
		heapify($arr, $n, $i);
	}

	// Постепенно извлекаем элементы из кучи
	for ($i = $n - 1; $i > 0; $i--) {
		// Меняем корень кучи с последним элементом массива
		$temp = $arr[0];
		$arr[0] = $arr[$i];
		$arr[$i] = $temp;

		heapify($arr, $i, 0);
	}
}

function heapify(&$arr, $n, $i)
{
	$largest = $i;
	$left = 2 * $i + 1;
	$right = 2 * $i + 2;

	if ($left < $n && $arr[$left] > $arr[$largest]) {
		$largest = $left;
	}

	if ($right < $n && $arr[$right] > $arr[$largest]) {
		$largest = $right;
	}

	if ($largest !== $i) {
		$temp = $arr[$i];
		$arr[$i] = $arr[$largest];
		$arr[$largest] = $temp;

		// Рекурсивно применяем heapify к измененной подкуче
		heapify($arr, $n, $largest);
	}
}

// Пример использования
$arr = [12, 11, 13, 5, 6, 7];
heapSort($arr);

echo "Отсортированный массив: " . implode(", ", $arr);
