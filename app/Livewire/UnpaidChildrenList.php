<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Child;
class UnpaidChildrenList extends Component
{
    public $paymentTermId;
    public $unpaidChildren = [];

    public function mount($paymentTermId)
    {
        $this->paymentTermId = $paymentTermId;
        $this->loadUnpaidChildren();
    }

    public function render()
    {
        return view('livewire.unpaid-children-list');
    }

    public function loadUnpaidChildren()
    {
        $this->unpaidChildren = Child::whereDoesntHave('receivedPayments')
            ->where('payment_term_id', $this->paymentTermId)
            ->get();
    }

}
