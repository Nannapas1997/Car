<div class="space-y-2">
    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
        <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.admin_name">


    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
        {{ __('trans.addressee.text') }}

            </span>


        </label>

    </div>

    <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">



        <div class="flex-1">
            <input type="text" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" x-bind:class="{
                    'border-gray-300': ! ('data.admin_name' in $wire.__instance.serverMemo.errors),
                    'dark:border-gray-600': ! ('data.admin_name' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                    'border-danger-600 ring-danger-600': ('data.admin_name' in $wire.__instance.serverMemo.errors),
                    'dark:border-danger-400 dark:ring-danger-400': ('data.admin_name' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                }" value="{{ \Filament\Facades\Filament::auth()->user()->name }}" disabled>
        </div>



    </div>


</div>
