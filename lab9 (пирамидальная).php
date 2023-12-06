<?php

function heapSort(&$arr)
{
	$n = count($arr);

	for ($i = ($n / 2) - 1; $i >= 0; $i--) {
		heapify($arr, $n, $i);
	}

	for ($i = $n - 1; $i > 0; $i--) {
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

		heapify($arr, $n, $largest);
	}
}

$arr = [12, 11, 13, 5, 6, 7];
heapSort($arr);

echo "Отсортированный массив: " . implode(", ", $arr);
