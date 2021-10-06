<input
    type="{{ $type }}"
    @isset($name) name="{{ $name }}" @endisset
    @isset($value) value="{{ $value }}" @endisset
    @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
    @isset($readonly) readonly @endisset
    @isset($disabled) disabled @endisset
    class="
        transition delay-70 duration-300 ease-in-out
        border border-primary border-opacity-25 rounded-lg
        text-sm
        focus:border-primary
        {{ isset($extraClassName) ? $extraClassName : '' }}">
