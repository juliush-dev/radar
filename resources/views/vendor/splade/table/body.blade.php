<tbody class="shadow-sm divide-y divide-slate-200 bg-slate-50 dark:bg-slate-200">
    @forelse($table->resource as $itemKey => $item)
        <tr
            :class="{
                'bg-slate-50': table.striped && @js($itemKey) % 2,
                'hover:bg-slate-200': table.striped,
                'hover:bg-slate-200 dark:hover:bg-slate-300': !table.striped,
            }">
            @if ($hasBulkActions = $table->hasBulkActions())
                <td width="64" class="text-xs px-6 py-4 max-w-0 overflow-auto">
                    @php $itemPrimaryKey = $table->findPrimaryKey($item) @endphp

                    <input @change="(e) => table.setSelectedItem(@js($itemPrimaryKey), e.target.checked)"
                        :checked="table.itemIsSelected(@js($itemPrimaryKey))"
                        :disabled="table.allItemsFromAllPagesAreSelected"
                        class="rounded border-teal-500 shadow-sm focus:border-teal-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 disabled:opacity-50"
                        name="table-row-bulk-action" type="checkbox" value="{{ $itemPrimaryKey }}" />
                </td>
            @endif

            @foreach ($table->columns() as $column)
                <td @if ($table->rowLinks->has($itemKey)) @click="(event) => table.visit(@js($table->rowLinks->get($itemKey)), @js($table->rowLinkType), event)" @endif
                    v-show="table.columnIsVisible(@js($column->key))"
                    class="whitespace-nowrap text-sm @if ($loop->first && $hasBulkActions)
pr-6
@else
px-6
@endif py-4 max-w-[250px] overflow-x-auto @if ($column->highlight)
text-slate-900 font-medium
@else
text-slate-800
@endif @if ($table->rowLinks->has($itemKey))
cursor-pointer
@endif {{ $column->classes }}">
                    <div
                        class="flex flex-row items-center @if ($column->alignment == 'right') justify-end @elseif($column->alignment == 'center') justify-center @else justify-start @endif @if (!$loop->first) capitalize @endif">
                        @isset(${'spladeTableCell' . $column->keyHash()})
                            {{ ${'spladeTableCell' . $column->keyHash()}($item, $itemKey) }}
                        @else
                            {!! nl2br(e($getColumnDataFromItem($item, $column))) !!}
                        @endisset
                    </div>
                </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{ $table->columns()->count() }}" class="whitespace-nowrap">
                @if (isset($emptyState) && !!$emptyState)
                    {{ $emptyState }}
                @else
                    <p class="text-fuchsia-700 px-6 py-12 font-medium text-sm text-center">
                        {{ __('There are no items to show.') }}
                    </p>
                @endif
            </td>
        </tr>
    @endforelse
</tbody>
