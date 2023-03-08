<div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="container mx-auto py-2 md:py-10 z-40">
        <div class="mb-5 w-64">
            <div class="relative w-64 mx-auto">
                <input type="hidden" name="date" x-ref="date">
                <input
                    type="text"
                    readonly
                    wire:model="datepickerValue"
                    @click="showDatepicker = !showDatepicker"
                    @keydown.escape="showDatepicker = false"
                    class="w-3/4 pl-10 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                    placeholder="{{ $currentDate ? $currentDate : 'เลือกวันที่' }}">

                <div class="absolute top-0 left-0 px-3 py-2">
                    <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div
                    class="bg-white mt-12 rounded-lg shadow p-4 absolute -top-10 left-0 z-50"
                    style="width: 17rem"
                    x-show.transition="showDatepicker"
                    @click.away="showDatepicker = false"
                >
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                            <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                :disabled="month == 0 ? true : false"
                                @click="month--; getNoOfDays()">
                                <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button
                                type="button"
                                class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                :disabled="month == 11 ? true : false"
                                @click="month++; getNoOfDays()">
                                <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-3 -mx-1">
                        <template x-for="(day, index) in DAYS" :key="index">
                            <div style="width: 14.26%" class="px-1">
                                <div
                                    x-text="day"
                                    class="text-gray-800 font-medium text-center text-xs">
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="flex flex-wrap -mx-1">
                        <template x-for="blankday in blankdays">
                            <div
                                style="width: 14.28%"
                                class="text-center border p-1 border-transparent text-sm"
                            ></div>
                        </template>
                        <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                            <div style="width: 14.28%" class="px-1 mb-1">
                                <div
                                    @click="getDateValue(date)"
                                    x-text="date"
                                    class="cursor-pointer text-center"
                                ></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const MONTH_NAMES = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    const DAYS = ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'];

    function app() {
        return {
            showDatepicker: false,
            datepickerValue: '',

            month: '',
            year: '',
            no_of_days: [],
            blankdays: [],
            days: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],

            initDate() {
                let params = (new URL(document.location)).searchParams;
                let currentDate = params.get("date");

                if (currentDate) {
                    let spDate = currentDate.split('-')
                    this.month = +spDate[1] - 1;
                    this.year = +spDate[0];
                    // this.datepickerValue = new Date(this.year, this.month, +spDate[2]).toDateString();
                } else {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    // this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                }
            },
            isToday(date) {
                let today = new Date();
                let params = (new URL(document.location)).searchParams;
                let currentDate = params.get("date");

                if (currentDate) {
                    let spDate = currentDate.split('-')
                    today = new Date(+spDate[0], +spDate[1] - 1, +spDate[2])
                }

                const d = new Date(+this.year, +this.month, date);
                return today.toDateString() === d.toDateString();
            },
            getDateValue(date) {
                let selectedDate = new Date(this.year, +this.month, date);
                // this.datepickerValue = selectedDate.toDateString();
                this.$refs.date.value = selectedDate.getFullYear() +"-"+ ('0'+ selectedDate.getMonth()).slice(-2) +"-"+ ('0' + selectedDate.getDate()).slice(-2);

                let params = (new URL(document.location)).searchParams;
                let currentDate = params.get("date");

                if (currentDate) {
                    const domainUrl = window.location.href.split('?')[0]
                    window.location.assign(domainUrl + '?date=' + this.year + '-' + (parseInt(this.month) + 1) + '-' + selectedDate.getDate());
                } else {
                    window.location.assign(window.location.href.split('?')[0] + '?date=' + this.year + '-' + (parseInt(this.month) + 1) + '-' + selectedDate.getDate());
                }

                this.showDatepicker = false;
            },

            getNoOfDays() {
                let daysInMonth = new Date(this.year, +this.month + 1, 0).getDate();

                // find where to start calendar day of week
                let dayOfWeek = new Date(this.year, this.month).getDay();
                let blankdaysArray = [];
                for ( var i=1; i <= dayOfWeek; i++) {
                    blankdaysArray.push(i);
                }

                let daysArray = [];
                for ( var i=1; i <= daysInMonth; i++) {
                    daysArray.push(i);
                }

                this.blankdays = blankdaysArray;
                this.no_of_days = daysArray;
            }
        }
    }
</script>
