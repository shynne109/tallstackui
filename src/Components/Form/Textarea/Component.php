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
            'floating' => [
                'label' => 'absolute text-sm duration-300 transform -translate-y-3 scale-[0.85] top-0.5 z-10 origin-[0] bg-white dark:bg-dark-800 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-5 peer-focus:top-0.5 peer-focus:scale-[0.85] peer-focus:-translate-y-3 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1',
                'color' => 'text-gray-500 dark:text-dark-400 peer-focus:text-primary-600 dark:peer-focus:text-primary-500',
                'input' => 'px-2.5! pt-5! pb-2.5!',
                'error' => 'text-red-600 peer-focus:text-red-600 dark:text-red-500',
            ],
            'error' => $this->error(),
            'count' => [
                'base' => 'dark:text-dark-400 absolute right-0 mt-1 text-sm text-gray-500',
                'max' => 'font-semibold text-red-500 dark:text-red-500',
            ],
        ]);
    }

    /** @throws InvalidArgumentException */
    protected function validate(): void
    {
        if ($this->attributes->has('rows') && $this->resizeAuto) {
            __ts_validation_exception($this, 'The textarea cannot be used with [rows] and [resize-auto] at the same time because the rows will have no effect since resizing is automatic.');
        }
    }
}
