@props([
    'label' => '',
    'type' => 'text',
    'value' => '',
    'name',
    'rows' => 3
])

@if ($label)
    <label for="{{$name}}">{{$label}}</label>
@endif

<textarea
    name="{{$name}}"
    id="{{$name}}"
    rows="{{$rows}}"
    {{ $attributes->class([
        'form-control',
        'form-control-alternative',
        'is-invalid' => $errors->has($name),
        ]) }}

>{{old($name, $value)}}</textarea>


{{-- Validation --}}
@error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror
