<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\AttendanceRegister;
use App\Models\Child;
use App\Models\ClassGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Collection;

class Attendance extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Take Attendance';
    protected static ?string $slug = 'attendance';
    protected static ?string $navigationGroup = 'Attendance Management';
    protected static string $view = 'filament.pages.attendance';

    public ?array $data = [];

    public function mount(): void
    {
        $receivedDate = request('received_date', now()->toDateString());
        $classGroupId = request('class_group_id');

        $this->form->fill([
            'received_date' => $receivedDate,
            'class_group_id' => $classGroupId,
            'children' => $this->getChildrenData($classGroupId, $receivedDate),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('received_date')
                    ->label('Date')
                    ->required()
                    ->default(now()),
                Select::make('class_group_id')
                    ->label('Class Group')
                    ->options(ClassGroup::pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set, $state) => $set('children', $this->getChildrenData($state, $this->data['received_date']))),
                Repeater::make('children')
                    ->schema([
                        Hidden::make('child_id'),
                        Select::make('child_name')
                            ->label('Child')
                            ->options(function (callable $get) {
                                $classGroupId = $get('../../class_group_id');
                                if (!$classGroupId) {
                                    return Collection::make();
                                }
                                return Child::where('class_group_id', $classGroupId)
                                    ->pluck('first_name', 'id');
                            })
                            ->disabled()
                            ->required(),
                        Toggle::make('present')
                            ->label('Present')
                            ->default(true),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(2),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
            ])
            ->statePath('data');
    }

    public function getChildrenData($classGroupId, $receivedDate): array
    {
        if (!$classGroupId) {
            return [];
        }

        $children = Child::where('class_group_id', $classGroupId)->get();
        $attendanceRecords = AttendanceRegister::where('class_group_id', $classGroupId)
            ->where('received_date', $receivedDate)
            ->get()
            ->keyBy('child_id');

        return $children->map(function ($child) use ($attendanceRecords) {
            $record = $attendanceRecords->get($child->id);
            return [
                'child_id' => $child->id,
                'child_name' => $child->id,
                'present' => $record ? $record->present : true,
                'notes' => $record ? $record->notes : '',
            ];
        })->toArray();
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $receivedDate = $data['received_date'];
        $classGroupId = $data['class_group_id'];

        foreach ($data['children'] as $record) {
            AttendanceRegister::updateOrCreate(
                [
                    'received_date' => $receivedDate,
                    'class_group_id' => $classGroupId,
                    'child_id' => $record['child_id'],
                ],
                [
                    'present' => $record['present'],
                    'notes' => $record['notes'] ?? '',
                    'company_id' => auth()->user()->company_id,
                ]
            );
        }

        $this->redirect(AttendanceList::getUrl());
    }
}
