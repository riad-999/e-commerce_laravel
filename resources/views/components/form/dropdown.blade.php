@props()

<label for={{$attributes['name']}}>{{$attributes['name']}}</label>
<input {{ $attributes }} id={{ $attributes['name'] }}/>
