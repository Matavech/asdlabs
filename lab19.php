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

function circleFromThreePoints($x1, $y1, $x2, $y2, $x3, $y3) {
	$a = $x1 - $x2;
	$b = $y1 - $y2;
	$c = $x1 - $x3;
	$d = $y1 - $y3;

	$e = ($x1 * $x1 - $x2 * $x2 + $y1 * $y1 - $y2 * $y2) / 2;
	$f = ($x1 * $x1 - $x3 * $x3 + $y1 * $y1 - $y3 * $y3) / 2;

	$det = $b * $c - $a * $d;

	if (abs($det) < 1e-6) {
		return false;
	}

	$hx = ($e * $d - $f * $b) / $det;
	$hy = ($a * $f - $c * $e) / $det;

	$radius = sqrt(($hx - $x1) ** 2 + ($hy - $y1) ** 2);

	$center = ['x' => $hx, 'y' => $hy];

	return ['center' => $center, 'radius' => $radius];
}

function isTriangle($x1, $y1, $x2, $y2, $x3, $y3) {
	$area = 0.5 * abs(($x1 * ($y2 - $y3) + $x2 * ($y3 - $y1) + $x3 * ($y1 - $y2)));

	return $area != 0;
}

// Большая окружность по трем точкам
$bigCx1 = -4;
$bigCy1 = 3;
$bigCx2 = -6;
$bigCy2 = -3;
$bigCx3 = 1;
$bigCy3 = -2;

//Малая окружность по трем точкам
$smallCx1 = -5;
$smallCy1 = 1;
$smallCx2 = -5;
$smallCy2 = -1;
$smallCx3 = -3;
$smallCy3 = -1;

//Треугольник
$rx1 = -1;
$ry1 = 0;
$rx2 = -2;
$ry2 = -2;
$rx3 = 0;
$ry3 = -2;

// Проверяем соответствие условиям
$count = 0;
$bigCircle = circleFromThreePoints($bigCx1,$bigCy1, $bigCx2, $bigCy2, $bigCx3, $bigCy3);
$bigCircleX = $bigCircle['center']['x'];
$bigCircleY = $bigCircle['center']['y'];
$bigCircleR = $bigCircle['radius'];
if ($bigCircle) {
	echo 'Большая окружность существует' . PHP_EOL;
	$count++;
}
$smallCircle = circleFromThreePoints($smallCx1,$smallCy1, $smallCx2, $smallCy2, $smallCx3, $smallCy3);
$smallCircleX = $smallCircle['center']['x'];
$smallCircleY = $smallCircle['center']['y'];
$smallCircleR = $smallCircle['radius'];
if ($smallCircle) {
	echo 'Малая окружность существует  ' . PHP_EOL;
	$count++;
}
if (isTriangle($rx1, $ry1, $rx2, $ry2, $rx3,$ry3)){
	echo 'Треугольник существует' . PHP_EOL;
	$count++;
}

//Проверка лежит ли малая окружность в большой
//Окружность B лежит внутри окружности A, если расстояние между центрами окружностей меньше разности радиусов окружностей
if (sqrt(($bigCircleX - $smallCircleX)**2 + ($bigCircleY-$smallCircleY)**2) < $smallCircleR) {
	echo 'Малая окружность лежит в большой окружности' . PHP_EOL;
	$count++;
}

//Функция для проверки, лежит ли треугольник в окружности
function isTriangleInsideCircle($x1, $y1, $x2, $y2, $x3, $y3, $cx, $cy, $r) {
	$distance1 = sqrt(($x1 - $cx) ** 2 + ($y1 - $cy) ** 2);
	$distance2 = sqrt(($x2 - $cx) ** 2 + ($y2 - $cy) ** 2);
	$distance3 = sqrt(($x3 - $cx) ** 2 + ($y3 - $cy) ** 2);

	return $distance1 < $r && $distance2 < $r && $distance3 < $r;
}
if (isTriangleInsideCircle($rx1,$ry1,$rx2,$ry2,$rx3,$ry3,$bigCircleX,$bigCircleY,$bigCircleR)) {
	echo 'Треугольник лежит в большой окружности' . PHP_EOL;
	$count++;
}

//Функция для проверки, пересекается ли треугольник с окружностью
function isTriangleIntersectsCircle($x1,$y1,$x2,$y2,$x3,$y3,$cx,$cy,$cr) {
	$first = intersectSegmentCircle($x1,$y1,$x2,$y2,$cx,$cy,$cr);
	$second = intersectSegmentCircle($x2,$y2,$x3,$y3,$cx,$cy,$cr);
	$third = intersectSegmentCircle($x1,$y1,$x3,$y3,$cx,$cy,$cr);
	return !$first && !$second && !$third;
}
if (isTriangleIntersectsCircle($rx1,$ry1,$rx2,$ry2,$rx3,$ry3,$smallCircleX,$smallCircleY,$smallCircleR)) {
	echo 'Треугольник и малая окружность не пересекаются' . PHP_EOL;
	$count++;
}

if(isTriangleInsideCircle($rx1,$ry1,$rx2,$ry2,$rx3,$ry3,$smallCircleX,$smallCircleY,$smallCircleR)) {
	echo 'Треугольник НЕ вложен в малую окружность' . PHP_EOL;
	$count++;
}

// Всего 7 условий
if ($count===7) echo 'Все проверки пройдены успешно';