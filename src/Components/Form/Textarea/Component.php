<?php

namespace TallStackUi\Components\Form\Textarea;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentSlot;
use InvalidArgumentException;
use TallStackUi\Attributes\PassThroughRuntime;
use TallStackUi\Attributes\SoftCustomization;
use TallStackUi\Components\Traits\FormDefaultInputClasses;
use TallStackUi\Customization\Contracts\Customization;
use TallStackUi\Support\Runtime\Components\TextareaRuntime;
use TallStackUi\TallStackUiComponent;

#[SoftCustomization('form.textarea')]
#[PassThroughRuntime(TextareaRuntime::class)]
class Component extends TallStackUiComponent implements Customization
{
    use FormDefaultInputClasses;

    public function __construct(
        public ComponentSlot|string|null $label = null,
        public ComponentSlot|string|null $hint = null,
        public ?bool $resize = false,
        public ?bool $resizeAuto = false,
        public ?bool $invalidate = null,
        public ?bool $floating = null,
        public string $floatingStyle = 'outlined',
        public ?bool $count = false,
    ) {
        //
    }

    public function blade(): View
    {
        return view('ts-ui::components.form.textarea');
    }

    public function customization(): array
    {
        return Arr::dot([
            'input' => [...$this->input()],
            'floating' => $this->floatingClasses(),
            'error' => $this->error(),
            'count' => [
                'base' => 'dark:text-dark-400 absolute right-0 mt-1 text-sm text-gray-500',
                'max' => 'font-semibold text-red-500 dark:text-red-500',
            ],
        ]);
    }

    protected function floatingClasses(): array
    {
        return match ($this->floatingStyle) {
            'filled' => [
                'label' => 'absolute text-sm duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto',
                'color' => 'text-gray-500 dark:text-dark-400 peer-focus:text-primary-600 dark:peer-focus:text-primary-500',
                'input' => 'rounded-t-md! rounded-b-none! border-0! border-b-2! border-gray-300! bg-gray-50! px-2.5! pt-5! pb-2.5! ring-0! focus:ring-0! focus:border-primary-600! dark:bg-dark-700! dark:border-dark-500! dark:focus:border-primary-500!',
                'error' => 'text-red-600 peer-focus:text-red-600 dark:text-red-500',
            ],
            'standard' => [
                'label' => 'absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto',
                'color' => 'text-gray-500 dark:text-dark-400 peer-focus:text-primary-600 dark:peer-focus:text-primary-500',
                'input' => 'rounded-none! border-0! border-b-2! border-gray-300! bg-transparent! px-0! py-2.5! ring-0! focus:ring-0! focus:border-primary-600! dark:border-dark-500! dark:focus:border-primary-500!',
                'error' => 'text-red-600 peer-focus:text-red-600 dark:text-red-500',
            ],
            default => [
                'label' => 'absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-dark-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1',
                'color' => 'text-gray-500 dark:text-dark-400 peer-focus:text-primary-600 dark:peer-focus:text-primary-500',
                'input' => 'pt-5! pb-1.5!',
                'error' => 'text-red-600 peer-focus:text-red-600 dark:text-red-500',
            ],
        };
    }

    /** @throws InvalidArgumentException */
    protected function validate(): void
    {
        if ($this->attributes->has('rows') && $this->resizeAuto) {
            __ts_validation_exception($this, 'The textarea cannot be used with [rows] and [resize-auto] at the same time because the rows will have no effect since resizing is automatic.');
        }

        if ($this->floating && ! in_array($this->floatingStyle, ['outlined', 'filled', 'standard'])) {
            __ts_validation_exception($this, 'The [floating-style] must be one of: outlined, filled, standard');
        }
    }
}
