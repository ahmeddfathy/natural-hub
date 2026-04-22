@props(['name'])

@error($name)
    <div class="text-danger mt-2">{{ $message }}</div>
@enderror