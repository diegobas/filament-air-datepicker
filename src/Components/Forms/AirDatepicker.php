<?php

namespace DiegoBas\FilamentAirDatepicker\Components\Forms;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\Exceptions\InvalidFormatException;
use Closure;
use Filament\Forms\Components\Field;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Date;

class AirDatepicker extends Field
{
    protected string $view = 'filament-air-datepicker::forms.air-datepicker';

    protected CarbonInterface | string | Closure | null $maxDate = null;
    protected CarbonInterface | string | Closure | null $minDate = null;
    protected string $dateFormat = 'yyyy-MM-dd';

    protected bool | Closure $hasTime = false;
    protected bool $onlyTime = false;

    protected int $hoursStep = 1;
    protected int $minutesStep = 15;
    protected string | Closure | null $startHour = null;

    public int | Closure $minHours = 0;
    protected int | Closure $maxHours = 23;
    protected int | Closure $minMinutes = 0;
    protected int | Closure $maxMinutes = 59;

    /*
    public static function make(string $name): static {
        $static = parent::make($name);

        return $static;
    }
    */

    public function minDate(CarbonInterface | string | Closure | null $date): static {
        $this->minDate = $date;

        $this->rule(static function (AirDatepicker $component) {
            $maxDate = \Carbon\Carbon::parse($component->getMaxDate())->endOfDay();
            return "before_or_equal:{$maxDate}";
        }, static fn (AirDatepicker $component): bool => (bool) $component->getMaxDate());

        return $this;
    }

    public function getMinDate(): ?string {
        return $this->evaluate($this->minDate);
    }

    public function maxDate(CarbonInterface | string | Closure | null $date): static {
        $this->maxDate = $date;

        $this->rule(static function (AirDatepicker $component) {
            $minDate = \Carbon\Carbon::parse($component->getMinDate())->startOfDay();
            return "after_or_equal:{$minDate}";
        }, static fn (AirDatepicker $component): bool => (bool) $component->getMaxDate());

        return $this;
    }

    public function getMaxDate(): ?string {
        return $this->evaluate($this->maxDate);
    }

    public function format(string $format): static {
        $this->dateFormat = $format;

        return $this;
    }

    public function getFormat(): string {
        if ($this->hasTime()) {
            return $this->dateFormat . ' HH:mm';
        }

        return $this->dateFormat;
    }

    public function time(bool | Closure $time = true): static {
        $this->hasTime = $time;

        return $this;
    }

    public function hasTime(): bool {
        return (bool) $this->evaluate($this->hasTime);
    }

    public function onlyTime(bool $time = true): static {
        $this->onlyTime = $time;

        return $this;
    }

    public function getOnlyTime(): bool {
        return $this->onlyTime;
    }

    public function hoursStep(int $step): static {
        $this->hoursStep = $step;

        return $this;
    }

    public function getHoursStep(): int {
        return $this->hoursStep;
    }

    public function minutesStep(int $step): static {
        $this->minutesStep = $step;

        return $this;
    }

    public function getMinutesStep(): int {
        return $this->minutesStep;
    }

    public function startHour(string | Closure | null $hour = null): static {
        $this->startHour = $hour;

        return $this;
    }

    public function getStartHour(): string | Closure | null {
        return $this->evaluate($this->startHour);
    }

    public function minHours(int | Closure $hours): static {
        if ($this->minHours && $this->minHours !== $hours) {
            dd($this->minHours, $hours);
        }

        $this->minHours = $hours;

        return $this;
    }

    public function getMinHours(): int | Closure {
        return (int) $this->evaluate($this->minHours);
    }

    public function maxHours(int | Closure $hours): static {
        $this->maxHours = $hours;

        return $this;
    }

    public function getMaxHours(): int | Closure {
        return (int) $this->evaluate($this->maxHours);
    }

    public function minMinutes(int | Closure $minutes): static {
        $this->minMinutes = $minutes;

        return $this;
    }

    public function getMinMinutes(): int | Closure {
        return (int) $this->evaluate($this->minMinutes);
    }

    public function maxMinutes(int | Closure $minutes): static {
        $this->maxMinutes = $minutes;

        return $this;
    }

    public function getMaxMinutes(): int | Closure {
        return (int) $this->evaluate($this->maxMinutes);
    }
}
