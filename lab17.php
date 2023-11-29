<?php

class Node
{
	public $data;
	public $left;
	public $right;

	public function __construct($data)
	{
		$this->data = $data;
		$this->left = null;
		$this->right = null;
	}
}

class BinarySearchTree
{
	protected $root;

	public function __construct()
	{
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

	public function delete($data)
	{
		$this->root = $this->deleteNode($this->root, $data);
	}

	protected function deleteNode($node, $data)
	{
		if ($node === null) {
			return null;
		}

		if ($data < $node->data) {
			$node->left = $this->deleteNode($node->left, $data);
		} elseif ($data > $node->data) {
			$node->right = $this->deleteNode($node->right, $data);
		} else {
			if ($node->left === null) {
				return $node->right;
			} elseif ($node->right === null) {
				return $node->left;
			}
			$node->data = $this->minValue($node->right);

			$node->right = $this->deleteNode($node->right, $node->data);
		}

		return $node;
	}

	protected function minValue($node)
	{
		$current = $node;

		while ($current->left !== null) {
			$current = $current->left;
		}

		return $current->data;
	}

	public function search($data)
	{
		return $this->searchNode($this->root, $data) !== null;
	}

	protected function searchNode($node, $data)
	{
		if ($node === null || $node->data === $data) {
			return $node;
		}

		if ($data < $node->data) {
			return $this->searchNode($node->left, $data);
		}

		return $this->searchNode($node->right, $data);
	}

	public function printTreeLinearly()
	{
		echo $this->generateLinearRepresentation($this->root) . PHP_EOL;
	}

	protected function generateLinearRepresentation($node)
	{
		if ($node === null) {
			return '';
		}

		$result = $node->data;

		if ($node->left || $node->right) {
			$result .= ' (';
			$result .= $this->generateLinearRepresentation($node->left);
			if ($node->right) {
				$result .= ', ';
			}
			$result .= $this->generateLinearRepresentation($node->right);
			$result .= ')';
		}

		return $result;
	}

}


function printMenu()
{
	echo "1. Добавить элемент\n";
	echo "2. Удалить элемент\n";
	echo "3. Поиск элемента\n";
	echo "4. Вывести дерево\n";
	echo "5. Выйти\n";
	echo "Выберите операцию: ";
}

$bst = new BinarySearchTree();

do {
	printMenu();
	$choice = trim(readline());

	switch ($choice) {
		case 1:
			echo "Введите значение для добавления: ";
			$value = trim(readline());
			$bst->insert($value);
			break;
		case 2:
			echo "Введите значение для удаления: ";
			$value = trim(readline());
			$bst->delete($value);
			break;
		case 3:
			echo "Введите значение для поиска: ";
			$value = trim(readline());
			$searchResult = $bst->search($value);
			echo "Результат поиска: " . ($searchResult ? "Найдено" : "Не найдено") . PHP_EOL;
			break;
		case 4:
			echo "Дерево: ";
			$bst->printTreeLinearly();
			echo PHP_EOL;
			break;
		case 5:
			echo "Программа завершена.\n";
			break;
		default:
			echo "Некорректный выбор. Пожалуйста, выберите снова.\n";
	}
} while ($choice != 5);