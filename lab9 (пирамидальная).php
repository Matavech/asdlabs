<?php

function buildHeap($arr, $n, $root) {
	$largest = $root;
	$leftChild = 2 * $root + 1;
	$rightChild = 2 * $root + 2;

	// Находим наибольший элемент среди корня и его детей
	if ($leftChild < $n && $arr[$leftChild] > $arr[$largest]) {
		$largest = $leftChild;
	}

	if ($rightChild < $n && $arr[$rightChild] > $arr[$largest]) {
		$largest = $rightChild;
	}

	if ($largest != $root) {
		// Если наибольший элемент не корень, меняем их местами
		$temp = $arr[$root];
		$arr[$root] = $arr[$largest];
		$arr[$largest] = $temp;

		// Рекурсивно строим стопку для дочернего поддерева
		$arr = buildHeap($arr, $n, $largest);
	}

	return $arr;
}

function heapSort($arr) {
	$n = count($arr);

	// Строим начальное дерево (перегруппируем массив)
	for ($i = $n / 2 - 1; $i >= 0; $i--) {
		$arr = buildHeap($arr, $n, $i);
	}

	// Извлекаем элементы из стопки по одному и помещаем их в конец массива
	for ($i = $n - 1; $i >= 0; $i--) {
		// Меняем местами корень стопки (наибольший элемент) с последним элементом в массиве
		$temp = $arr[0];
		$arr[0] = $arr[$i];
		$arr[$i] = $temp;

		// Рекурсивно строим стопку для уменьшенной части массива
		$arr = buildHeap($arr, $i, 0);
	}

	return $arr;
}

$array = [12, 11, 13, 5, 6];
$sortedArray = heapSort($array);

echo "Отсортированный массив: " . implode(", ", $sortedArray);