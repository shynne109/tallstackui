<?php

namespace TallStackUi\Components\Tab\Main;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use TallStackUi\Attributes\SoftCustomization;
use TallStackUi\Customization\Contracts\Customization;
use TallStackUi\TallStackUiComponent;

#[SoftCustomization('tab')]
class Component extends TallStackUiComponent implements Customization
{
    public function __construct(
        public ?string $selected = null,
        public ?bool $scrollOnMobile = null,
        public ?bool $centered = null,
        public string $variant = 'default',
        public string $direction = 'horizontal',
    ) {
        //
    }

    public function blade(): View
    {
        return view('ts-ui::components.tab.main');
    }

    public function customization(): array
    {
        $isVertical = $this->direction === 'vertical';

        if ($this->variant === 'pills') {
            $item = [
                'wrapper' => 'inline-flex items-center gap-2 whitespace-nowrap px-4 py-2 transition-all rounded-full',
                'select' => 'text-white bg-primary-500 dark:bg-primary-600 hover:bg-primary-600 dark:hover:bg-primary-700 font-medium cursor-pointer',
                'unselect' => 'text-gray-500 dark:text-dark-400 hover:text-gray-700 dark:hover:text-dark-300 hover:bg-gray-100 dark:hover:bg-dark-600 cursor-pointer font-medium',
            ];
        } elseif ($isVertical) {
            $item = [
                'wrapper' => 'inline-flex items-center gap-2 whitespace-nowrap px-4 py-3 transition-all w-full',
                'select' => 'text-primary-500 dark:text-dark-300 border-primary-500 dark:border-dark-300 cursor-pointer border-l-2 font-medium bg-primary-50 dark:bg-dark-600',
                'unselect' => 'dark:text-dark-500 cursor-pointer border-l-2 border-transparent font-medium text-gray-400 hover:text-gray-600 dark:hover:text-dark-300 hover:bg-gray-50 dark:hover:bg-dark-600',
            ];
        } else {
            $item = [
                'wrapper' => 'inline-flex items-center gap-2 whitespace-nowrap p-4 transition-all',
                'select' => 'text-primary-500 dark:text-dark-300 border-primary-500 dark:border-dark-300 group inline-flex cursor-pointer items-center border-b-2 font-medium',
                'unselect' => 'dark:text-dark-500 cursor-pointer border-b-2 border-transparent font-medium text-gray-400 flex',
            ];
        }

        return Arr::dot([
            'base' => [
                'wrapper' => 'dark:bg-dark-700 w-full rounded-lg bg-white shadow-md',
                'padding' => 'p-2 sm:p-0',
                'body' => 'soft-scrollbar flex-nowrap overflow-auto flex',
                'content' => 'text-secondary-700 dark:text-dark-300 p-4',
                'divider' => 'h-px border-0 bg-gray-300 dark:bg-dark-600',
                'select' => 'focus:border-primary-500 focus:ring-primary-500 dark:bg-dark-700 dark:border-dark-500 w-full rounded-lg border-gray-200 px-4 py-3 dark:text-dark-400 sm:hidden',
            ],
            'item' => $item,
        ]);
    }
}
