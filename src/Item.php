<?php declare(strict_types = 1);

namespace GrandMedia\Widgets;

use Assert\Assertion;
use Nette\Application\UI\Control;

final class Item
{

	/**
	 * @var int
	 */
	private $position;

	/**
	 * @var callable
	 */
	private $factory;

	public function __construct(int $position, callable $factory)
	{
		Assertion::greaterOrEqualThan($position, 0);

		$this->position = $position;
		$this->factory = $factory;
	}

	public function getPosition(): int
	{
		return $this->position;
	}

	public function getControl(): Control
	{
		return \call_user_func($this->factory);
	}

}
