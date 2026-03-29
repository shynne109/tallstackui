<?php

namespace TallStackUi\Components\Form\Input;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentSlot;
use TallStackUi\Attributes\PassThroughRuntime;
use TallStackUi\Attributes\SkipDebug;
use TallStackUi\Attributes\SoftCustomization;
use TallStackUi\Components\Traits\FormDefaultInputClasses;
use TallStackUi\Customization\Contracts\Customization;
use TallStackUi\Support\Runtime\Components\InputRuntime;
use TallStackUi\TallStackUiComponent;

#[SoftCustomization('form.input')]
#[PassThroughRuntime(InputRuntime::class)]
class Component extends TallStackUiComponent implements Customization
{
    use FormDefaultInputClasses;

    public function __construct(
        public ComponentSlot|string|null $label = null,
        public ComponentSlot|string|null $hint = null,
        public ?string $icon = null,
        public ?bool $clearable = null,
        public ?bool $invalidate = null,
        public ?bool $stripZeros = null,
        public ?bool $floating = null,
        #[SkipDebug]
        public ?string $position = 'left',
        #[SkipDebug]
        public ComponentSlot|string|null $prefix = null,
        #[SkipDebug]
        public ComponentSlot|string|null $suffix = null,
    ) {
        $this->position = $this->position === 'left' ? 'left' : 'right';
    }

    public function blade(): View
    {
        return view('ts-ui::components.form.input');
    }

    public function customization(): array
    {
        return Arr::dot([
            'input' => [
                ...$this->input(),
                'paddings' => [
                    'prefix' => 'pr-3 pl-0',
                    'suffix' => 'pl-3 pr-0',
                    'left' => 'pl-8',
                    'right' => 'pr-8',
                    'clearable' => '!pr-14',
                ],
                'addon' => [
                    'wrapper' => 'flex w-full rounded-md ring-1 focus-within:ring-2 focus-within:ring-primary-600 dark:focus-within:ring-primary-600',
                    'round' => [
                        'left' => 'rounded-l-none!',
                        'right' => 'rounded-r-none!',
                    ],
                    'error' => 'ring-red-300 focus-within:ring-red-500 dark:ring-red-500 dark:focus-within:ring-red-500',
                    'button' => [
                        'base' => 'flex-none [&>button]:h-full! [&>a]:h-full! [&>button]:border-0! [&>a]:border-0! [&>button]:focus:ring-0! [&>a]:focus:ring-0! [&>button]:focus:ring-offset-0! [&>a]:focus:ring-offset-0! [&>button]:shadow-none! [&>a]:shadow-none! [&>button]:hover:shadow-none! [&>a]:hover:shadow-none! [&>button]:focus:shadow-none! [&>a]:focus:shadow-none!',
                        'left' => '[&>button]:rounded-r-none! [&>a]:rounded-r-none! [&>button]:rounded-l-md [&>a]:rounded-l-md',
                        'right' => '[&>button]:rounded-l-none! [&>a]:rounded-l-none! [&>button]:rounded-r-md [&>a]:rounded-r-md',
                    ],
                ],
            ],
            'icon' => [
                'wrapper' => 'pointer-events-none absolute inset-y-0 flex items-center text-gray-500 dark:text-dark-400',
                'paddings' => [
                    'left' => 'left-0 pl-2',
                    'right' => 'right-0 pr-2',
                ],
                'size' => 'h-5 w-5',
                'color' => 'text-gray-500 dark:text-dark-400',
            ],
            'clearable' => [
                'wrapper' => 'cursor-pointer absolute inset-y-0 flex items-center text-gray-500 dark:text-dark-400',
                'padding' => 'right-0 pr-2',
                'size' => 'h-5 w-5',
                'color' => 'hover:text-red-500',
            ],
            'floating' => [
                'label' => 'absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1',
                'color' => 'text-gray-500 dark:text-dark-400 peer-focus:text-primary-600 dark:peer-focus:text-primary-500',
                'input' => 'pt-3.5! pb-1.5!',
                'error' => 'text-red-600 peer-focus:text-red-600 dark:text-red-500',
            ],
            'error' => $this->error(),
        ]);
    }

    protected function validate(): void
    {
        if ($this->icon && (($this->position === 'left' && $this->prefix !== null) || ($this->position === 'right' && $this->suffix !== null))) {
            __ts_validation_exception($this, 'The [icon] cannot be used with [prefix] or [suffix] at the same side');
        }

        if ($this->clearable && $this->suffix !== null) {
            __ts_validation_exception($this, 'The [clearable] cannot be used with [suffix]');
        }

        if ($this->floating && ($this->prefix !== null || $this->suffix !== null)) {
            __ts_validation_exception($this, 'The [floating] cannot be used with [prefix] or [suffix]');
        }
    }
}
