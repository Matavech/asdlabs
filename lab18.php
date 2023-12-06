<?php

class Node {
	public $data;
	public $left;
	public $right;

	public function __construct($item) {
		$this->data = $item;
		$this->left = null;
		$this->right = null;
	}
}

class BinarySearchTree {
	public $root;

	public function __construct() {
		$this->root = null;
	}

	public function insert($data)
	{
		$this->root = $this->insertNode($this->root, $data);
	}

	protected function insertNode($node, $data)
	{
		if ($node === null) {
			return new Node($data);
		}

		if ($data < $node->data) {
			$node->left = $this->insertNode($node->left, $data);
		} elseif ($data > $node->data) {
			$node->right = $this->insertNode($node->right, $data);
		}

		return $node;
	}


	public function inOrder($node, &$result) {
		if ($node) {
			$this->inOrder($node->left, $result);
			$result[] = $node->data;
			$this->inOrder($node->right, $result);
		}
	}
}


$arr = [12, 11, 13, 5, 6, 7];
$bst = new BinarySearchTree();

foreach ($arr as $item) {
	$bst->insert($item);
}
$sortedArray = [];
$bst->inOrder($bst->root, $sortedArray);

echo "Отсортированный массив: " . implode(", ", $sortedArray);

