<div>
    @if ($file)
        <h3>Attached File:</h3>
        <img src="{{ Storage::disk('public')->url($file) }}" alt="Ticket File" class="w-full h-auto" />
    @else
        <p>No file attached.</p>
    @endif
</div>
