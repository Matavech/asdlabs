<?php
function partition(&$arr, $low, $high) {
	// Выбираем опорный элемент (в данном случае, последний элемент)
	$pivot = $arr[$high];

	// Инициализируем индекс элемента, который будет служить разделителем
	$i = $low - 1;

	for ($j = $low; $j < $high; $j++) {
		// Если текущий элемент меньше или равен опорному
		if ($arr[$j] <= $pivot) {
			// Увеличиваем индекс разделителя
			$i++;

			// Меняем элементы местами
			$temp = $arr[$i];
			$arr[$i] = $arr[$j];
			$arr[$j] = $temp;
		}
	}

	// Меняем опорный элемент и элемент, который будет служить разделителем
	$temp = $arr[$i + 1];
	$arr[$i + 1] = $arr[$high];
	$arr[$high] = $temp;

	// Возвращаем индекс разделителя
	return $i + 1;
}

function quickSort(&$arr, $low, $high) {
	if ($low < $high) {
		// Находим индекс разделителя
		$partitionIndex = partition($arr, $low, $high);

		// Рекурсивно сортируем левую и правую части массива
		quickSort($arr, $low, $partitionIndex - 1);
		quickSort($arr, $partitionIndex + 1, $high);
	}
}

$arr = [12, 11, 13, 5, 6, 7];
$length = count($arr);
quickSort($arr, 0, $length - 1);
echo "Отсортированный массив: " . implode(", ", $arr);
