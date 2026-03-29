@php
    $customization = $classes();
@endphp

<x-dynamic-component :component="TallStackUi::prefix('wrapper.input')" :$id :$property :$error :$label :$hint
                     :$invalidate :$floating>
    <div x-data="tallstackui_formTextArea(@js($resizeAuto), @js($customization['count.max']))">
        <div @class([
            $customization['input.wrapper'],
            $customization['input.color.base'] => !$error,
            $customization['input.color.background'] => !$attributes->get('disabled') && !$attributes->get('readonly'),
            $customization['input.color.disabled'] => $attributes->get('disabled') || $attributes->get('readonly'),
            $customization['error'] => $error,
        ])>
            <textarea @if ($id) id="{{ $id }}" @endif
            x-ref="textarea"
                      @if ($floating) placeholder="{{ $attributes->get('placeholder', ' ') }}" @endif
                      @if ($count) x-on:keyup="counter()" @endif
                      @if ($resizeAuto) x-on:input="resize()" @endif
                    {{ $attributes->class([
                        'resize-none' => !$resize && !$resizeAuto,
                        'peer' => $floating,
                        $customization['floating.input'] => $floating,
                        $customization['input.base'],
                    ])->merge(['rows' => 3]) }}>{{ $attributes->get('value', $slot) }}</textarea>
            @if ($floating && $label && is_string($label))
                <label @if ($id) for="{{ $id }}" @endif @class([
                    $customization['floating.label'],
                    $customization['floating.color'] => !$error,
                    $customization['floating.error'] => $error,
                ])>{{ $label }}</label>
            @endif
        </div>
        @if ($count)
            <span class="{{ $customization['count.base'] }}" x-ref="counter"></span>
        @endif
    </div>
</x-dynamic-component>
