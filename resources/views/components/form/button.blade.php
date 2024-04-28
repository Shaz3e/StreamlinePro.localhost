@props([
    'text' => 'Save & Back',
    'icon' => 'ri-save-line',
    'class' => '',
    'name' => '',
])
<button type="submit" name="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'btn btn-success btn-sm waves-effect waves-light ' . $class,
    ]) }}>
    <i class="{{ $icon }} align-middle me-2"></i>
    {{ $text }}
</button>
