@props([
    'label' => '',
    'type' => 'text',
    'value' => '',
    'name',
])

@if ($label)
    <label for="{{$name}}">{{$label}}</label>
@endif
<input
    type="{{$type}}"
    name="{{$name}}"
    id="{{$name}}"
    value="{{old($name, $value)}}"
    {{ $attributes->class([
        'form-control',
        'form-control-alternative',
        'is-invalid' => $errors->has($name),
        ]) }}
>

{{-- Validation --}}
@error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror
