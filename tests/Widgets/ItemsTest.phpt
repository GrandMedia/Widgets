<?php declare(strict_types = 1);

namespace GrandMediaTests\Widgets;

use GrandMedia\Widgets\Item;
use GrandMedia\Widgets\Items;
use GrandMediaTests\Widgets\Mocks\BlankControl;
use Nette\Application\UI\Control;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
final class ItemsTest extends \Tester\TestCase
{

	public function testAdd(): void
	{
		$items = $this->createItems(
			[
				[1, 'one'],
				[2, 'two'],
			]
		);

		Assert::same(2, \count($items->getIndexes()));
	}

	/**
	 * @throws \RuntimeException
	 */
	public function testAddAfterSort(): void
	{
		$items = $this->createItems([]);
		$items->getIndexes();

		$items->add(new Item(1, function (): void {
		}));
	}

	public function testSort(): void
	{
		$items = $this->createItems(
			[
				[5, 'two'],
				[500, 'last'],
				[5, 'one'],
				[1, 'first'],
			]
		);

		$sortedLabels = [];
		foreach ($items->getIndexes() as $index) {
			/** @var \GrandMediaTests\Widgets\Mocks\BlankControl $control */
			$control = $items->getControl($index);
			$sortedLabels[] = $control->getLabel();
		}

		Assert::true($items->isSorted());
		Assert::same(['first', 'two', 'one', 'last'], $sortedLabels);
	}

	/**
	 * @param mixed[] $settings
	 */
	private function createItems(array $settings): Items
	{
		$items = new Items();

		foreach ($settings as $setting) {
			$items->add(
				new Item(
					$setting[0],
					function () use ($setting): Control {
						return new BlankControl($setting[1]);
					}
				)
			);
		}

		return $items;
	}

}

(new ItemsTest())->run();
