@php
    $customization = $classes();
    $isVertical = $direction === 'vertical';
@endphp

<div x-data="tallstackui_tab(@if (!$selected) {!! TallStackUi::blade($attributes, $livewire)->entangle() !!} @else @js($selected) @endif)"
     @class([
         $customization['base.wrapper'],
         'flex flex-col sm:flex-row' => $isVertical,
     ])>
    @if (!$scrollOnMobile)
        <div class="{{ $customization['base.padding'] }}">
            <select x-model="selected" class="{{ $customization['base.select'] }}" aria-label="Select a tab"
                    x-on:change="change()">
                <template x-for="item in tabs">
                    <option x-bind:value="item.tab" x-text="item.title ?? item.tab"
                            x-bind:selected="item.tab === selected">
                    </option>
                </template>
            </select>
        </div>
    @endif
    <ul role="tablist"
        @class([
            $customization['base.body'],
            'hidden sm:flex' => ! $scrollOnMobile && ! $isVertical,
            'hidden sm:flex sm:flex-col sm:min-w-[200px] sm:border-r sm:border-b-0 border-gray-300 dark:border-dark-600' => $isVertical,
            'justify-center' => $centered && ! $isVertical,
            'gap-2 p-2' => $variant === 'pills',
        ]) {{ $attributes->only('x-on:navigate') }} x-ref="ul">
        <template x-for="item in tabs">
            <li role="tab"
                tabindex="0"
                x-on:click="select(item)"
                x-on:keypress.enter="select(item)"
                x-on:mouseenter="prefetch(item)"
                x-bind:aria-selected="selected === item.tab ? 'true' : 'false'"
                x-bind:class="{
                    '{{ $customization['item.select'] }}' : selected === item.tab,
                    '{{ $customization['item.unselect'] }}' : selected !== item.tab,
                    @if (! $isVertical)
                    'hidden sm:flex': selected !== item.tab && ! @js($scrollOnMobile),
                    @endif
                }">
                <div class="{{ $customization['item.wrapper'] }}">
                    <template x-if="item.left">
                        <div x-html="item.left"></div>
                    </template>
                    <span x-text="item.title ?? item.tab"></span>
                    <template x-if="item.right">
                        <div x-html="item.right"></div>
                    </template>
                </div>
            </li>
        </template>
    </ul>
    @if ($variant !== 'pills' && ! $isVertical)
        <hr @class([$customization['base.divider'], 'hidden sm:block' => ! $scrollOnMobile])>
    @endif
    <div @class([
        $customization['base.content'],
        'flex-1' => $isVertical,
    ])>
        {{ $slot }}
    </div>
</div>
