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
        $this->form->fill();
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
                    ->afterStateUpdated(fn (callable $set) => $set('children', [])),
                Repeater::make('children')
                    ->schema([
                        Select::make('child_id')
                            ->label('Child')
                            ->options(function (callable $get) {
                                $classGroupId = $get('../../class_group_id');
                                if (!$classGroupId) {
                                    return Collection::make();
                                }
                                return Child::where('class_group_id', $classGroupId)
                                    ->pluck('first_name', 'id');
                            })
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

    public function create(): void
    {
        $records = $this->form->getState()['children'];

        foreach ($records as $record) {
            AttendanceRegister::create([
                'received_date' => $this->form->getState()['received_date'],
                'class_group_id' => $this->form->getState()['class_group_id'],
                'child_id' => $record['child_id'],
                'present' => $record['present'],
                'notes' => $record['notes'],
                'company_id' => auth()->user()->company_id,
            ]);
        }

        $this->redirect(AttendanceList::getUrl());
    }
}
