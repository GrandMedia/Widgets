<?php declare(strict_types = 1);

namespace GrandMediaTests\Widgets;

use GrandMedia\Widgets\Components;
use GrandMediaTests\Widgets\Mocks\BlankControl;
use Nette\Application\UI\Control;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class ComponentsTest extends \Tester\TestCase
{

	public function testAdd(): void
	{
		$components = $this->createComponents(
			[
				[1, 'one'],
				[2, 'two'],
			]
		);

		Assert::same(2, \count($components->getPositions()));
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function testAddSamePosition(): void
	{
		$this->createComponents(
			[
				[1, 'one'],
				[1, 'two'],
			]
		);
	}

	public function testGetPositions(): void
	{
		$components = $this->createComponents(
			[
				[2, 'two'],
				[1, 'one'],
			]
		);

		Assert::same([1, 2], $components->getPositions());
	}

	public function testGetComponent(): void
	{
		$components = $this->createComponents(
			[
				[1, 'one'],
				[2, 'two'],
			]
		);

		/** @var \GrandMediaTests\Widgets\Mocks\BlankControl $control */
		$control = $components->getControl(1);
		Assert::true($control instanceof BlankControl);
		Assert::same('one', $control->getLabel());
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function testGetNotExistComponent(): void
	{
		$components = $this->createComponents(
			[
				[1, 'one'],
				[2, 'two'],
			]
		);

		$components->getControl(3);
	}

	/**
	 * @param mixed[] $settings
	 * @throws \InvalidArgumentException
	 */
	private function createComponents(array $settings): Components
	{
		$components = new Components();

		foreach ($settings as $setting) {
			$components->add(
				$setting[0],
				function () use ($setting): Control {
					return new BlankControl($setting[1]);
				}
			);
		}

		return $components;
	}

}

(new ComponentsTest())->run();
