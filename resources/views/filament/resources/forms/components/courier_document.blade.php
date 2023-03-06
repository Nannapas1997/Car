<div class="space-y-2">
    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
        <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.courier_document">
            <span class="text-sm font-medium leading-4 text-gray-700">
                ผู้นำส่งเอกสาร
                <sup class="font-medium text-danger-700">*</sup>
            </span>
        </label>

    </div>
    <div class="flex-1">
        <input type="text"  class="block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300" x-bind:class="{
                'border-gray-300': ! ('data.courier_document' in $wire.__instance.serverMemo.errors),
                'dark:border-gray-600': ! ('data.courier_document' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                'border-danger-600 ring-danger-600': ('data.courier_document' in $wire.__instance.serverMemo.errors),
                'dark:border-danger-400 dark:ring-danger-400': ('data.courier_document' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
            }" value="{{ \Filament\Facades\Filament::auth()->user()->name }}" disabled>
    </div>
</div>
