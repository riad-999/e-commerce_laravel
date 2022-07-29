@props(['name', 'msg' => null])

@error($name)
    <small class="block text-red-500 text-sm font-semibold">{{ $msg ? $msg : $message }}</small>
@enderror