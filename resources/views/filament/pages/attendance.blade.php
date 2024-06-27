<x-filament-panels::page>
    <form wire:submit.prevent="saveAttendance">
        <div class="space-y-6">
            <div>
                <x-forms::field-group>
                    <x-forms::field-wrapper id="date" label="Date">
                        <x-filament::forms.date-picker wire:model="date" id="date" />
                    </x-forms::field-wrapper>
                </x-forms::field-group>
                
            </div>
            <div>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2">Child</th>
                            <th class="py-2">Present</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->children as $child)
                            <tr>
                                <td class="py-2">{{ $child->first_name }} {{ $child->surname }}</td>
                                <td class="py-2 text-center">
                                    <input type="checkbox" name="attendance[{{ $child->id }}]" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <x-filament::button type="submit">Save Attendance</x-filament::button>
            </div>
        </div>
    </form>
</x-filament-panels::page>
