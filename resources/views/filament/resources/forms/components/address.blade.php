<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


        <input type="text" id="zipcode"  class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600">


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
            <input type="text" id="district"  class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" >
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
            <input type="text" id="amphoe" required="" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" >
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
            <input  type="text" id="province" class="bg-white block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600" >
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
