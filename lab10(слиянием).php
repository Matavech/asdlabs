<?php
function merge(&$arr, $left, $mid, $right) {
	// Вычисляем размер временных подмассивов
	$n1 = $mid - $left + 1;
	$n2 = $right - $mid;

	// Создаем временные подмассивы и копируем данные
	$leftArray = array_slice($arr, $left, $n1);
	$rightArray = array_slice($arr, $mid + 1, $n2);

	// Индексы для обхода временных подмассивов
	$i = 0;
	$j = 0;
	// Индекс для обхода основного массива
	$k = $left;

	// Объединяем временные подмассивы обратно в основной массив
	while ($i < $n1 && $j < $n2) {
		if ($leftArray[$i] <= $rightArray[$j]) {
			$arr[$k] = $leftArray[$i];
			$i++;
		} else {
			$arr[$k] = $rightArray[$j];
			$j++;
		}
		$k++;
	}

	// Копируем оставшиеся элементы из $leftArray (если есть)
	while ($i < $n1) {
		$arr[$k] = $leftArray[$i];
		$i++;
		$k++;
	}

	// Копируем оставшиеся элементы из $rightArray (если есть)
	while ($j < $n2) {
		$arr[$k] = $rightArray[$j];
		$j++;
		$k++;
	}
}

function mergeSort(&$arr, $left, $right) {
	if ($left < $right) {
		// Находим средний индекс массива
		$mid = floor(($left + $right) / 2);

		// Рекурсивно сортируем две половины
		mergeSort($arr, $left, $mid);
		mergeSort($arr, $mid + 1, $right);

		// Объединяем отсортированные половины
		merge($arr, $left, $mid, $right);
	}
}


$arr = [12, 11, 13, 5, 6, 7];
$length = count($arr);
mergeSort($arr, 0, $length - 1);
echo "Отсортированный массив: " . implode(", ", $arr);
