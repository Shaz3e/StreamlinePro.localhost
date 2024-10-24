@props([
    'text' => 'Save & Back',
    'icon' => 'ri-save-line',
    'class' => 'btn-success btn-sm',
    'name' => '',
])
<button type="submit" name="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'btn waves-effect waves-light ' . $class,
    ]) }}>
    <i class="{{ $icon }} align-middle me-2"></i>
    {{ $text }}
</button>
