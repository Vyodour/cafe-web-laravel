@props(['name', 'id' => null, 'label' => '', 'checked' => false, 'value' => '1'])

@php
    $id = $id ?? $name;
@endphp

<div class="flex items-center space-x-3">
    <!-- Hidden input for "unchecked" state (optional, usually handled by form logic or hidden field before) -->
    
    <button type="button" 
            role="switch" 
            aria-checked="{{ $checked ? 'true' : 'false' }}"
            x-data="{ on: @js($checked) }"
            x-on:click="on = !on; $refs.checkbox.checked = on; $refs.checkbox.dispatchEvent(new Event('change'))"
            :class="on ? 'bg-amber-600' : 'bg-stone-200 dark:bg-stone-700'"
            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-amber-600 focus:ring-offset-2 dark:focus:ring-offset-stone-900">
        
        <span class="sr-only">{{ $label }}</span>
        
        <span aria-hidden="true" 
              :class="on ? 'translate-x-5' : 'translate-x-0'"
              class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
        </span>
    </button>
    
    <!-- Actual Checkbox (Hidden) -->
    <input type="checkbox" 
           name="{{ $name }}" 
           id="{{ $id }}" 
           value="{{ $value }}" 
           x-ref="checkbox"
           class="sr-only"
           {{ $checked ? 'checked' : '' }}>

    @if($label)
        <label for="{{ $id }}" class="text-sm font-medium text-stone-900 dark:text-stone-300 cursor-pointer" @click="$refs.checkbox.click()">
            {{ $label }}
        </label>
    @endif
</div>
