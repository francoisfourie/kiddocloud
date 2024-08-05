<x-filament-panels::page>
    <x-filament::button
        href="{{ \App\Filament\Pages\Attendance::getUrl() }}"
        color="primary"
        class="mb-4"
    >
        Take Attendance
    </x-filament::button>

    {{ $this->table }}
</x-filament-panels::page>