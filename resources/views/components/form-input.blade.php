{{-- We define the variables this component needs: name, label, and type --}}
@props(['name', 'label', 'type' => 'text'])

<div class="mb-3">
    {{-- 1. Automated Label --}}
    <label class="form-label">{{ $label }}</label>

    {{-- 2. Smart Input: Handles its own 'is-invalid' class and 'old()' values --}}
    <input type="{{ $type }}" 
           name="{{ $name }}" 
           value="{{ old($name) }}" 
           class="form-control @error($name) is-invalid @enderror">

    {{-- 3. Inline Error: Automatically shows the error for this specific field --}}
    @error($name)
        <div class="text-danger mt-1" style="font-size: 0.9rem;">
            <i class="fa fa-info-circle"></i> {{ $message }}
        </div>
    @enderror
</div>