<?php
class TreeNode {
	public $value;
	public $up;
	public $left;
	public $right;

	public function __construct($value, $up = null) {
		$this->value = $value;
		$this->up = $up;
		$this->left = null;
		$this->right = null;
	}

	public function preOrder($node) {
		if ($node) {
			echo $node->value . ' ';
			$this->preOrder($node->left);
			$this->preOrder($node->right);
		}
	}

	public function inOrder($node) {
		if ($node) {
			$this->inOrder($node->left);
			echo $node->value . ' ';
			$this->inOrder($node->right);
		}
	}

	public function postOrder($node) {
		if ($node) {
			$this->postOrder($node->left);
			$this->postOrder($node->right);
			echo $node->value . ' ';
		}
	}

	public function nonRecursivePreOrder($node) {
		if ($node) {
			$stack = [$node];
			while (!empty($stack)) {
				$curRoot = array_pop($stack);
				echo $curRoot->value . ' ';
				if ($curRoot->right) {
					$stack[] = $curRoot->right;
				}
				if ($curRoot->left) {
					$stack[] = $curRoot->left;
				}
			}
		}
	}
}

function createTree($char, $node, $q) {
	$i = 0;
	if ($char[$i] === "(") {
		$i++;
		if ($char[$i] === ",") {
			return createTree(substr($char, $i), $node, $q);
		}
		if (is_numeric($char[$i])) {
			$s = $char[$i];
			$j = $i + 1;
			while (is_numeric($char[$j])) {
				$s .= $char[$j];
				$j++;
			}
			$s = (int)$s;
			$node->left = new TreeNode($s, $node);
			if ($char[$j] === "(") {
				return createTree(substr($char, $j), $node->left, $q);
			}
			return createTree(substr($char, $j), $node, $q);
		}
	}
	if ($char[$i] === ",") {
		$i++;
		if ($char[$i] === ")") {
			return createTree(substr($char, $i), $node->up, $q);
		}
		if (is_numeric($char[$i])) {
			$s = $char[$i];
			$j = $i + 1;
			while (is_numeric($char[$j])) {
				$s .= $char[$j];
				$j++;
			}
			$s = (int)$s;
			$node->right = new TreeNode($s, $node);
			if ($char[$j] === "(") {
				return createTree(substr($char, $j), $node->right, $q);
			}
			return createTree(substr($char, $j), $node, $q);
		}
	}
	if ($char[$i] === ")" && strlen($char) === 1) {
		return $q;
	}
	if ($char[$i] === ")") {
		$i++;
		return createTree(substr($char, $i), $node->up, $q);
	}
}

$input = readline("Введите строку: ");
$q = (int)substr($input, 0, strpos($input, "("));
$tree = new TreeNode($q);
$input = str_replace(" ", "", substr($input, strpos($input, "(")));
$tree = createTree($input, $tree, $tree);

echo PHP_EOL;
echo "Прямой: ";
$tree->preOrder($tree);
echo PHP_EOL;
echo "Центральный: ";
$tree->inOrder($tree);
echo PHP_EOL;
echo "Концевой: ";
$tree->postOrder($tree);
echo PHP_EOL;
echo "Нерекурсивный: ";
$tree->nonRecursivePreOrder($tree);

// 8 (3 (1, 6 (4,7)), 10 (, 14(13,)))