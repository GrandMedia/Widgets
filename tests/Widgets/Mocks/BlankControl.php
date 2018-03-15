<?php declare(strict_types = 1);

namespace GrandMediaTests\Widgets\Mocks;

final class BlankControl extends \Nette\Application\UI\Control
{

	/** @var string */
	private $label;

	public function __construct(string $label)
	{
		parent::__construct();

		$this->label = $label;
	}

	public function render(): void
	{
	}

	public function getLabel(): string
	{
		return $this->label;
	}

}
