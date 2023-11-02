<?php
function externalSort($inputFile, $outputFile, $chunkSize) {
	// Фаза 0: Разделение данных
	$chunks = [];
	$chunkCount = 0;
	$fileHandle = fopen($inputFile, 'r');

	while (!feof($fileHandle)) {
		$chunk = [];
		$fileChunkName = 'chunk' . $chunkCount . '.tmp';
		$chunkCount++;

		while (count($chunk) < $chunkSize && !feof($fileHandle)) {
			$line = fgets($fileHandle);
			$chunk[] = trim($line);
		}

		sort($chunk);
		file_put_contents($fileChunkName, implode("\n", $chunk));
		$chunks[] = $fileChunkName;
	}

	fclose($fileHandle);

	// Фазы 1 и выше: Сортировка и слияние
	while (count($chunks) > 1) {
		$newChunks = [];
		for ($i = 0; $i < count($chunks); $i += 2) {
			$chunk1 = file($chunks[$i], FILE_IGNORE_NEW_LINES);
			$chunk2 = ($i + 1 < count($chunks)) ? file($chunks[$i + 1], FILE_IGNORE_NEW_LINES) : [];

			$mergedChunk = mergeChunks($chunk1, $chunk2);
			$newChunkName = 'merged' . $i . '.tmp';

			file_put_contents($newChunkName, implode("\n", $mergedChunk));
			$newChunks[] = $newChunkName;

			// Удаляем временные файлы
			unlink($chunks[$i]);
			if ($i + 1 < count($chunks)) {
				unlink($chunks[$i + 1]);
			}
		}

		$chunks = $newChunks;
	}

	// Сохранение отсортированных данных в выходной файл
	rename($chunks[0], $outputFile);
}

function mergeChunks($chunk1, $chunk2) {
	$merged = [];
	$i = 0;
	$j = 0;

	while ($i < count($chunk1) && $j < count($chunk2)) {
		if ($chunk1[$i] < $chunk2[$j]) {
			$merged[] = $chunk1[$i];
			$i++;
		} else {
			$merged[] = $chunk2[$j];
			$j++;
		}
	}

	while ($i < count($chunk1)) {
		$merged[] = $chunk1[$i];
		$i++;
	}

	while ($j < count($chunk2)) {
		$merged[] = $chunk2[$j];
		$j++;
	}

	return $merged;
}


externalSort('input.txt', 'output.txt', 10);