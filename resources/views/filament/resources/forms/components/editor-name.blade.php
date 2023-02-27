
        <div class="space-y-2">
            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.editor_name">
                        <span class="text-sm font-medium leading-4 text-gray-700">
                    {{ __('trans.editor_name.text') }}
                        </span>


                </label>

            </div>
        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
            <div class="flex-1">
                <input x-data="{}" wire:model.defer="data.editor_name" type="text" dusk="filament.forms.data.editor_name" id="data.editor_name" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300" x-bind:class="{
                        'border-gray-300': ! ('data.editor_name' in $wire.__instance.serverMemo.errors),
                        'dark:border-gray-600': ! ('data.editor_name' in $wire.__instance.serverMemo.errors) &amp;&amp; false,
                        'border-danger-600 ring-danger-600': ('data.editor_name' in $wire.__instance.serverMemo.errors),
                        'dark:border-danger-400 dark:ring-danger-400': ('data.editor_name' in $wire.__instance.serverMemo.errors) &amp;&amp; false,
                    }" value="{{ \Filament\Facades\Filament::auth()->user()->name }}" disabled >
            </div>
        </div>
    
