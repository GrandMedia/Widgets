<?php declare(strict_types = 1);

namespace GrandMedia\Widgets;

use Nette\Application\UI\Control;
use function Safe\sprintf;
use function Safe\usort;

final class Items
{

	/**
	 * @var \GrandMedia\Widgets\Item[]
	 */
	private $items = [];

	/**
	 * @var bool
	 */
	private $sorted = false;

	public function add(Item $item): void
	{
		if ($this->sorted) {
			throw new \RuntimeException('Items are sorted.');
		}
		$this->items[] = $item;
	}

	public function getControl(int $index): Control
	{
		if (!$this->sorted) {
			$this->sort();
		}

		if (!isset($this->items[$index])) {
			throw new \InvalidArgumentException(sprintf('Index %d does not exist.', $index));
		}

		return $this->items[$index]->getControl();
	}

	/**
	 * @return int[]
	 */
	public function getIndexes(): array
	{
		if (!$this->sorted) {
			$this->sort();
		}

		return \array_keys($this->items);
	}

	public function isSorted(): bool
	{
		return $this->sorted;
	}

	private function sort(): void
	{
		$index = 0;
		$tmp = [];
		foreach ($this->items as $item) {
			$tmp[] = [$index++, $item];
		}

		usort(
			$tmp,
			function (array $a, array $b): int {
				$result = \call_user_func(
					function (Item $one, Item $two): int {
						return $one->getPosition() - $two->getPosition();
					},
					$a[1],
					$b[1]
				);

				return $result === 0 ? $a[0] - $b[0] : $result;
			}
		);

		$this->items = [];
		foreach ($tmp as $array) {
			$this->items[] = $array[1];
		}

		$this->sorted = true;
	}

}
