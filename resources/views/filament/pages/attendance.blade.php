<x-filament-panels::page>
    <form wire:submit.prevent="create">
        {{ $this->form }}

        <x-filament::button
            type="submit"
            class="mt-4"
        >
            Save Attendance
        </x-filament::button>
    </form>
</x-filament-panels::page>
