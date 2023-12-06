<?php

function intersectLines($a1, $b1, $c1, $a2, $b2, $c2) {
	$det = $a1 * $b2 - $a2 * $b1;
	if ($det == 0) {
		// Прямые параллельны или совпадают
		return false;
	} else {
		$x = ($c2 * $b1 - $c1 * $b2) / $det;
		$y = ($a1 * $c2 - $a2 * $c1) / $det;
		return ['x' => $x, 'y' => $y];
	}
}

function intersectLineSegment($a, $b, $c, $x1, $y1, $x2, $y2) {
	$result = intersectLines($a, $b, $c, $y1 - $y2, $x2 - $x1, $x1 * $y2 - $x2 * $y1);

	if (!$result) {
		return false;
	}

	$x = $result['x'];
	$y = $result['y'];

	if ($x >= min($x1, $x2) && $x <= max($x1, $x2) && $y >= min($y1, $y2) && $y <= max($y1, $y2)) {
		return $result;
	} else {
		return false;
	}
}

function intersectSegments($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4) {
	$result = intersectLines($y1 - $y2, $x2 - $x1, $x1 * $y2 - $x2 * $y1, $y3 - $y4, $x4 - $x3, $x3 * $y4 - $x4 * $y3);

	if (!$result) {
		return false;
	}

	$x = $result['x'];
	$y = $result['y'];

	if ($x >= min($x1, $x2) && $x <= max($x1, $x2) && $y >= min($y1, $y2) && $y <= max($y1, $y2) &&
		$x >= min($x3, $x4) && $x <= max($x3, $x4) && $y >= min($y3, $y4) && $y <= max($y3, $y4)) {
		return $result;
	} else {
		return false;
	}
}

function intersectLineCircle($a, $b, $c, $h, $k, $r) {
	$d = abs($a * $h + $b * $k + $c) / sqrt($a * $a + $b * $b);

	if ($d > $r) {
		return false;
	} else {
		$x1 = ($b * ($b * $h - $a * $k) - $a * $c) / ($a * $a + $b * $b);
		$y1 = ($a * (-$b * $h + $a * $k) - $b * $c) / ($a * $a + $b * $b);

		$x2 = $h + $a * $d / sqrt($a * $a + $b * $b);
		$y2 = $k + $b * $d / sqrt($a * $a + $b * $b);

		return [['x' => $x1, 'y' => $y1], ['x' => $x2, 'y' => $y2]];
	}
}

function intersectSegmentCircle($x1, $y1, $x2, $y2, $h, $k, $r) {
	$a = $x2 - $x1;
	$b = $y2 - $y1;
	$c = $x2 * $y1 - $x1 * $y2;

	$result = intersectLineCircle($a, $b, $c, $h, $k, $r);

	if (!$result) {
		return false;
	}

	$intersections = [];
	foreach ($result as $point) {
		$x = $point['x'];
		$y = $point['y'];
		if ($x >= min($x1, $x2) && $x <= max($x1, $x2) && $y >= min($y1, $y2) && $y <= max($y1, $y2)) {
			$intersections[] = $point;
		}
	}

	return $intersections;
}

function intersectCircles($x1, $y1, $r1, $x2, $y2, $r2) {
	$d = sqrt(($x2 - $x1) ** 2 + ($y2 - $y1) ** 2);

	if ($d > $r1 + $r2 || $d < abs($r1 - $r2)) {
		return false;
	} else {
		$a = ($r1 ** 2 - $r2 ** 2 + $d ** 2) / (2 * $d);
		$h = sqrt($r1 ** 2 - $a ** 2);

		$x3 = $x1 + $a * ($x2 - $x1) / $d;
		$y3 = $y1 + $a * ($y2 - $y1) / $d;

		$x4a = $x3 + $h * ($y2 - $y1) / $d;
		$y4a = $y3 - $h * ($x2 - $x1) / $d;

		$x4b = $x3 - $h * ($y2 - $y1) / $d;
		$y4b = $y3 + $h * ($x2 - $x1) / $d;

		return [['x' => $x4a, 'y' => $y4a], ['x' => $x4b, 'y' => $y4b]];
	}
}

// Функция для генерации случайной точки в пределах заданного прямоугольника
function generateRandomPoint($xmin, $xmax, $ymin, $ymax)
{
	$x = mt_rand($xmin, $xmax);
	$y = mt_rand($ymin, $ymax);

	return ['x' => $x, 'y' => $y];
}

// Генерируем 9 случайных точек
$points = [];
for ($i = 0; $i < 9; $i++)
{
	$points[] = generateRandomPoint(0, 100, 0, 100);
}

// Функция для проверки, является ли точка уникальной в массиве точек
function isUniquePoint($point, $points)
{
	foreach ($points as $existingPoint)
	{
		if ($existingPoint['x'] == $point['x'] && $existingPoint['y'] == $point['y'])
		{
			return false;
		}
	}

	return true;
}

// Выбираем 6 уникальных точек для треугольника
$trianglePoints = [];
while (count($trianglePoints) < 6)
{
	$point = generateRandomPoint(0, 100, 0, 100);
	if (isUniquePoint($point, $points))
	{
		$trianglePoints[] = $point;
		$points[] = $point;
	}
}

// Выбираем 3 уникальные точки для "большой" окружности
$bigCirclePoints = [];
while (count($bigCirclePoints) < 3)
{
	$point = generateRandomPoint(0, 100, 0, 100);
	if (isUniquePoint($point, $points))
	{
		$bigCirclePoints[] = $point;
		$points[] = $point;
	}
}

// Определяем параметры для окружностей
$bigCircleCenter = generateRandomPoint(0, 100, 0, 100);
$bigCircleRadius = mt_rand(30, 50);

$smallCircleCenter = $trianglePoints[0];
$smallCircleRadius = mt_rand(10, 20);

// Выводим точки и параметры окружностей
echo "Точки треугольника:\n";
print_r($trianglePoints);

echo "\nТочки большой окружности:\n";
print_r($bigCirclePoints);

echo "\nПараметры большой окружности:\n";
echo "Центр: ";
print_r($bigCircleCenter);
echo "Радиус: $bigCircleRadius\n";

echo "\nПараметры малой окружности:\n";
echo "Центр: ";
print_r($smallCircleCenter);
echo "Радиус: $smallCircleRadius\n";

// Находим пересечения окружностей
$circleIntersections = intersectCircles(
	$bigCircleCenter['x'],
	$bigCircleCenter['y'],
	$bigCircleRadius,
	$smallCircleCenter['x'],
	$smallCircleCenter['y'],
	$smallCircleRadius
);

echo "\nТочки пересечения окружностей:\n";
print_r($circleIntersections);

// Находим точки треугольника внутри большой окружности
$triangleInsideBigCircle = [];
foreach ($trianglePoints as $point)
{
	if (
		($point['x'] - $bigCircleCenter['x']) ** 2 + ($point['y'] - $bigCircleCenter['y']) ** 2 <= $bigCircleRadius
		** 2
	)
	{
		$triangleInsideBigCircle[] = $point;
	}
}

echo "\nТочки треугольника внутри большой окружности:\n";
print_r($triangleInsideBigCircle);

