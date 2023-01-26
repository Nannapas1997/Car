<div>
    @php
        $fileArr = explode('.', $getState());
    @endphp

    @if (count($fileArr) == 2)
        @if ($fileArr[1] == 'jpg' || $fileArr[1] == 'png' || $fileArr[1] == 'jpeg')
            <div style="height: 40px;" class="">
                <img src="{{env('APP_URL') . '/storage/' . $getState()}}" style="height: 40px;" class="">
            </div>
        @else
            <div style="height: 40px;" class="">
                <img src="{{env('APP_URL') . '/assets/images/icon-file.png'}}" style="height: 40px;" class="">
            </div>
        @endif
    @else
        <div style="height: 40px;" class="">
            <img src="{{env('APP_URL') . '/assets/images/icon-file.png'}}" style="height: 40px;" class="">
        </div>
    @endif
</div>
