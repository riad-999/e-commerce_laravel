@props(['date'])

@php
    $date = date('m-d-Y',strtotime($date));
    $date = str_replace('-','/',$date);
@endphp

<script>
    const countDown = new Date("{!! $date !!}").getTime();
</script>

<section class="flex gap-2 mb-4" id="countdown">
    <div class="text-black text-xl font-semibold p-2 pl-0 text-center">
        <div id="days">0</div>
        <div class="text-sm">Jrs</div>
    </div>
    <div class="text-black text-xl font-semibold p-2  text-center">
        <div id="hours">0</div>
        <div class="text-sm">Hrs</div>
    </div>
    <div class="text-black text-xl font-semibold p-2  text-center">
        <div id="minutes">0</div>
        <div class="text-sm">Mins</div>
    </div>
    <div class="text-black text-xl font-semibold p-2  text-center">
        <div id="seconds">0</div>
        <div class="text-sm">Secs</div>
    </div>
</section>