@props([
    'text' => 'Save & Create New',
    'icon' => 'ri-save-line',
    'class' => '',
])
<button type="submit" name="save_and_create_new"
    {{ $attributes->merge([
        'class' => 'btn btn-success btn-sm waves-effect waves-light ' . $class,
    ]) }}>
    <i class="{{ $icon }} align-middle me-2"></i>
    {{ $text }}
</button>
