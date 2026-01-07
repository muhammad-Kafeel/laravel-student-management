{{-- resources/views/components/student-input.blade.php --}}
@props(['name', 'label', 'icon', 'placeholder', 'type' => 'text'])

<div class="form-group mb-4">
    {{-- Label with custom CSS class --}}
    <label for="{{ $name }}" class="font-weight-600">{{ $label }}</label>
    
    <div class="input-group">
        <div class="input-group-prepend">
            {{-- Dynamic Icon passed through props --}}
            <span class="input-group-text bg-light border-right-0">
                <i class="{{ $icon }}"></i>
            </span>
        </div>
        
        {{-- 
            Smart Input: 
            1. 'old($name)' retains data if validation fails.
            2. '@error' adds the red border class automatically.
        --}}
        <input type="{{ $type }}" 
               name="{{ $name }}" 
               id="{{ $name }}" 
               value="{{ old($name) }}" 
               placeholder="{{ $placeholder }}"
               class="form-control border-left-0 pl-0 @error($name) is-invalid @enderror">
    </div>

    {{-- Inline Error Message --}}
    @error($name)
        <div class="text-danger small mt-1">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
        </div>
    @enderror
</div>