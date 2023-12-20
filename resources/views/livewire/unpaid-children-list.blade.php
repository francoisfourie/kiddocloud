
<div class="card">
    <div class="card-header">
        Unpaid Children for Payment Term #{{ $paymentTermId }}
    </div>
    <div class="card-body">
        @if ($unpaidChildren->isNotEmpty())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unpaidChildren as $child)
                        <tr>
                            <td>{{ $child->name }}</td>
                            <td>{{ $child->id }}</td>
                            <td>
                                <a href="{{ route('children.show', $child->id) }}" class="btn btn-sm btn-primary">View Child</a>
                                <button wire:click="sendPaymentReminder({{ $child->id }})" class="btn btn-sm btn-warning">Send Reminder</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No unpaid children found for this payment term.</p>
        @endif
    </div>
</div>
