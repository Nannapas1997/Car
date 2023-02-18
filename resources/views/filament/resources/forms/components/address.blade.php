<!DOCTYPE html>
<html lang="en">
<head>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
<script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
<style>
    .bg-white {
        background-color: white !important;
    }
</style>

</head>
<body>
<div class="filament-forms-field-wrapper">
    <div class="space-y-2">
        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.postal_code">
                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                {{ __('trans.postal_code.text') }}

                    <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                </span>
            </label>
        </div>
        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
            <div class="flex-1">
                <input type="text" id="zipcode" required="" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" x-bind:class="{
                        'border-gray-300': ! ('zipcode' in $wire.__instance.serverMemo.errors),
                        'dark:border-gray-600': ! ('zipcode' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                        'border-danger-600 ring-danger-600': ('zipcode' in $wire.__instance.serverMemo.errors),
                        'dark:border-danger-400 dark:ring-danger-400': ('zipcode' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                    }">
            </div>
        </div>
    </div>
    <br>
    <div class="space-y-2">
        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.district">


                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                {{ __('trans.district.text') }}

                    <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                </span>
            </label>

    </div>

    <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
        <div class="flex-1">
            <input type="text" id="district" required="" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" x-bind:class="{
                    'border-gray-300': ! ('district' in $wire.__instance.serverMemo.errors),
                    'dark:border-gray-600': ! ('district' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                    'border-danger-600 ring-danger-600': ('district' in $wire.__instance.serverMemo.errors),
                    'dark:border-danger-400 dark:ring-danger-400': ('district' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                }">
        </div>
    </div>
    </div>
    <br>
    <div class="space-y-2">
                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                    <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.amphoe">


    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
    {{ __('trans.amphoe.text') }}

                    <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
            </span>


</label>

                            </div>

        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">



        <div class="flex-1">
            <input type="text" id="amphoe" required="" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" x-bind:class="{
                    'border-gray-300': ! ('amphoe' in $wire.__instance.serverMemo.errors),
                    'dark:border-gray-600': ! ('amphoe' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                    'border-danger-600 ring-danger-600': ('amphoe' in $wire.__instance.serverMemo.errors),
                    'dark:border-danger-400 dark:ring-danger-400': ('amphoe' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                }">
        </div>



            </div>


            </div>
            <br>
            <div class="space-y-2">
                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                    <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.province">


    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
    {{ __('trans.province.text') }}

                    <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
            </span>


</label>

                            </div>

        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">



        <div class="flex-1">
            <input  type="text" id="province" required="" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" x-bind:class="{
                    'border-gray-300': ! ('province' in $wire.__instance.serverMemo.errors),
                    'dark:border-gray-600': ! ('province' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                    'border-danger-600 ring-danger-600': ('province' in $wire.__instance.serverMemo.errors),
                    'dark:border-danger-400 dark:ring-danger-400': ('province' in $wire.__instance.serverMemo.errors) &amp;&amp; true,
                }">
        </div>



            </div>


            </div>
</div>


<script>
    $.Thailand({
    $zipcode: $('#zipcode'),
    $district: $('#district'),
    $amphoe: $('#amphoe'),
    $province: $('#province'),
});
</script>
</body>
</html>
