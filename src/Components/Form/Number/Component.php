<?php

namespace TallStackUi\Components\Form\Number;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentSlot;
use TallStackUi\Attributes\PassThroughRuntime;
use TallStackUi\Attributes\SoftCustomization;
use TallStackUi\Components\Traits\FormDefaultInputClasses;
use TallStackUi\Customization\Contracts\Customization;
use TallStackUi\Support\Runtime\Components\NumberRuntime;
use TallStackUi\TallStackUiComponent;

#[SoftCustomization('form.number')]
#[PassThroughRuntime(NumberRuntime::class)]
class Component extends TallStackUiComponent implements Customization
{
    use FormDefaultInputClasses;

    public function __construct(
        public ComponentSlot|string|null $label = null,
        public ComponentSlot|string|null $hint = null,
        public ?int $min = null,
        public ?int $max = null,
        public ?int $delay = 2,
        public ?bool $selectable = null,
        public ?bool $chevron = false,
        public ?bool $invalidate = null,
        public ?bool $floating = null,
        public ?bool $centralized = null,
        public int|float $step = 1,
    ) {
        //
    }

    public function blade(): View
    {
        return view('ts-ui::components.form.number');
    }

    public function customization(): array
    {
        return Arr::dot([
            'input' => [...$this->input()],
            'buttons' => [
                'wrapper' => 'flex w-full items-center',
                'left' => [
                    'base' => 'inline-flex pr-3 items-center justify-center disabled:opacity-30 cursor-pointer',
                    'size' => 'ml-2 h-4 w-4',
                    'color' => 'dark:text-dark-400 text-gray-500',
                    'error' => 'text-red-500',
                ],
                'right' => [
                    'base' => 'inline-flex pl-3 items-center justify-center disabled:opacity-30 cursor-pointer',
                    'size' => 'mr-2 h-4 w-4',
                    'color' => 'dark:text-dark-400 text-gray-500',
                    'error' => 'text-red-500',
                ],
            ],
            'floating' => [
                'label' => 'inline-flex items-center absolute text-sm duration-300 transform -translate-y-3 scale-[0.85] top-0.5 z-10 origin-[0] bg-white dark:bg-dark-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-0.5 peer-focus:scale-[0.85] peer-focus:-translate-y-3 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1',
                'color' => 'text-gray-500 dark:text-dark-400 peer-focus:text-primary-600 dark:peer-focus:text-primary-500',
                'input' => 'pt-4! pb-2.5!',
                'error' => 'text-red-600 peer-focus:text-red-600 dark:text-red-500',
            ],
            'error' => $this->error(),
        ]);
    }

    final public function mode(): string
    {
        if (is_null($this->min) || $this->min < 0) {
            return 'text';
        }

        if ($this->step && $this->step < 1) {
            return 'decimal';
        }

        return 'numeric';
    }

    final public function pattern(): string
    {
        if (is_null($this->min) || $this->min < 0) {
            return '-?[0-9]*[.,]?[0-9]*';
        }

        if ($this->step && $this->step < 1) {
            return '[0-9]*[.,]?[0-9]*';
        }

        return '[0-9]*';
    }
}
