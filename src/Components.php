<?php declare(strict_types = 1);

namespace GrandMedia\Widgets;

use Nette\Application\UI\Control;
use function Safe\sort;
use function Safe\sprintf;

final class Components
{

	/**
	 * @var callable[]
	 */
	private $factories = [];

	public function add(int $position, callable $factory): void
	{
		if (isset($this->factories[$position])) {
			throw new \InvalidArgumentException(sprintf('Position %d is already set.', $position));
		}

		$this->factories[$position] = $factory;
	}

	public function getControl(int $position): Control
	{
		if (!isset($this->factories[$position])) {
			throw new \InvalidArgumentException(sprintf('Position %d does not exist.', $position));
		}

		return \call_user_func($this->factories[$position]);
	}

	/**
	 * @return int[]
	 */
	public function getPositions(): array
	{
		$positions = \array_keys($this->factories);
		sort($positions);

		return $positions;
	}

}
