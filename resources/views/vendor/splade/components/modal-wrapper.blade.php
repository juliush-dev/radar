<!--START-SPLADE-MODAL-{{ $key }}-->
<SpladeModal {{ $baseAttributes->mergeVueBinding(':close-button', $closeButton) }} :name="@js($name)">
    <template #default="modal">
        <x-splade-component is="transition" show="modal.isOpen">
            <x-splade-component is="dialog" v-bind:dusk="`modal.${modal.stack}`"
                close="{{ $closeExplicitly ? '' : 'modal.setIsOpen' }}" class="relative z-20">
                <!-- The backdrop, rendered as a fixed sibling to the panel container -->
                <x-splade-component is="transition" child v-if="modal.stack === 1 && modal.animate" animation="opacity">
                    <div v-show="modal.onTopOfStack" class="fixed z-30 inset-0" />
                </x-splade-component>

                <div v-if="(modal.stack === 1 && !modal.animate) || (modal.stack > 1 && modal.onTopOfStack)"
                    class="fixed z-30 inset-0" />
                <div class="modal-content-theme-setter relative w-full h-full">
                    {{ $slot }}
                </div>
                <x-splade-script>
                    if(window.document.getElementById('themeSetter')?.classList.contains('dark')){
                    window.document.querySelector('.modal-content-theme-setter')?.classList.toggle('dark');
                    };
                </x-splade-script>
            </x-splade-component>
        </x-splade-component>
    </template>
</SpladeModal>
<!--END-SPLADE-MODAL-{{ $key }}-->
