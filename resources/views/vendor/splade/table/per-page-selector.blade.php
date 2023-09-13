<select name="per_page"
    class="block focus:ring-emerald-500 focus:border-emerald-500 min-w-max shadow-sm text-sm border-teal-500 rounded-md"
    @change="table.updateQuery('perPage', $event.target.value)">
    @foreach ($table->allPerPageOptions() as $perPage)
        <option value="{{ $perPage }}" @selected($perPage === $table->perPage())>
            {{ $perPage }} {{ __('per page') }}
        </option>
    @endforeach
</select>
