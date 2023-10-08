<select name="per_page" class="block min-w-max shadow-sm text-sm"
    @change="table.updateQuery('perPage', $event.target.value)">
    @foreach ($table->allPerPageOptions() as $perPage)
        <option value="{{ $perPage }}" @selected($perPage === $table->perPage())>
            {{ $perPage }} {{ __('per page') }}
        </option>
    @endforeach
</select>
