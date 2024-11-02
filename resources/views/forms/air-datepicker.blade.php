@php
    $extraAttributes = $getExtraAttributes();
    $classes = 'w-full' . ($getExtraAttributes()['class'] ?? '');
    $statePath = $getStatePath();
    $id = $getId();
@endphp
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    :field="$field"
>
    <div
        x-ignore
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-air-datepicker', 'diegobas/filament-air-datepicker') }}"
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('filament-air-datepicker-styles', 'diegobas/filament-air-datepicker'))]"
        id="{{ $getId() }}"
        x-data="filamentAirDatepicker({
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            minDate: @js($getMinDate()),
            maxDate: @js($getMaxDate()),
            format: '{{ $getFormat() }}',
            hasTime: @js($hasTime()),
            onlyTime: @js($getOnlyTime()),
            hoursStep: @js($getHoursStep()),
            minutesStep: @js($getMinutesStep()),
            startHour: '{{ $getStartHour() }}',
            minHours: @js($getMinHours()),
            maxHours: @js($getMaxHours()),
            minMinutes: @js($getMinMinutes()),
            maxMinutes: @js($getMaxMinutes()),
            classes: @js($classes),
            defaultState: @js($getDefaultState())
        })"
    >
        <div x-ref="datepicker" wire:key="{{ $id }}" wire:ignore></div>
    </div>
</x-dynamic-component>
