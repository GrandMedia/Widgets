<?php declare(strict_types = 1);

namespace GrandMedia\Widgets;

use Assert\Assertion;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;

final class Widget extends \Nette\Application\UI\Control
{

	/**
	 * @var \GrandMedia\Widgets\Components
	 */
	private $components;

	/**
	 * @var string
	 */
	private $templateFile;

	/**
	 * @var \Nette\Localization\ITranslator|null
	 */
	private $translator;

	public function __construct(Components $components, string $templateFile, ?ITranslator $translator = null)
	{
		parent::__construct();

		Assertion::file($templateFile);

		$this->components = $components;
		$this->templateFile = $templateFile;
		$this->translator = $translator;
	}

	public function render(): void
	{
		/** @var \Nette\Bridges\ApplicationLatte\Template $template */
		$template = $this->getTemplate();
		$template->setFile($this->templateFile);
		$template->setTranslator($this->translator);

		$template->setParameters(
			[
				'positions' => $this->components->getPositions(),
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
		return $this->components->getControl((int) $name);
	}

}
