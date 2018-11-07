<?php declare(strict_types = 1);

namespace GrandMedia\Widgets;

use Assert\Assertion;
use Nette\Application\UI\Control;

final class Widget extends \Nette\Application\UI\Control
{

	/**
	 * @var \GrandMedia\Widgets\Items
	 */
	private $items;

	/**
	 * @var string
	 */
	private $templateFile;

	public function __construct(Items $items, string $templateFile)
	{
		parent::__construct();

		Assertion::file($templateFile);

		$this->items = $items;
		$this->templateFile = $templateFile;
	}

	public function render(): void
	{
		/** @var \Nette\Bridges\ApplicationLatte\Template $template */
		$template = $this->getTemplate();
		$template->setFile($this->templateFile);

		$template->setParameters(
			[
				'indexes' => $this->items->getIndexes(),
			]
		);

		$template->render();
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param string $name
	 */
	protected function createComponent($name): Control
	{
		return $this->items->getControl((int) $name);
	}

}
