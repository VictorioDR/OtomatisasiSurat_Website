<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Dokumen</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS untuk flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body class="bg-gray-50 text-gray-900">

@php
    $inputClasses = "
        block w-full rounded-lg
        border-gray-300
        bg-white
        text-gray-900
        shadow-sm
        focus:border-amber-500 focus:ring-amber-500
        sm:text-sm
    ";
@endphp

<div class="max-w-2xl mx-auto py-12 px-4">
    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-md">

        <header class="mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Generate: {{ $template->name }}
            </h1>
            <p class="mt-2 text-sm text-gray-600">{{ $template->description }}</p>
        </header>

        @if($errors->any())
            <div class="bg-red-500/10 text-red-600 ring-1 ring-inset ring-red-500/20 rounded-lg p-4 mb-6">
                <p class="font-bold">Oops! Terjadi kesalahan:</p>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('generate.run', $template) }}" method="POST" class="space-y-6">
            @csrf
            @foreach($template->formFields->sortBy('order') as $field)
                <div>
                    <label for="{{ $field->field_name }}"
                           class="block text-sm font-medium mb-2 text-gray-700">
                        {{ $field->label }}
                        @if($field->is_required) <span class="text-red-500">*</span> @endif
                    </label>

                    @switch($field->field_type)
                        @case('textarea')
                            <textarea id="{{ $field->field_name }}" name="fields[{{ $field->field_name }}]"
                                      class="{{ $inputClasses }}" rows="4"
                                      @if($field->is_required) required @endif>{{ old('fields.'.$field->field_name) }}</textarea>
                            @break

                        @case('select')
                            <select id="{{ $field->field_name }}" name="fields[{{ $field->field_name }}]"
                                    class="{{ $inputClasses }}" @if($field->is_required) required @endif>
                                <option value="">-- Pilih Salah Satu --</option>
                                @foreach($field->options as $option)
                                    <option value="{{ $option['key'] ?? $option['value'] }}"
                                        @selected((old('fields.'.$field->field_name) ?? '') == ($option['key'] ?? $option['value']))>
                                        {{ $option['value'] ?? $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @break

                        @case('date')
                            <input id="{{ $field->field_name }}" type="text"
                                   name="fields[{{ $field->field_name }}]"
                                   value="{{ old('fields.'.$field->field_name) }}"
                                   class="{{ $inputClasses }}"
                                   @if($field->is_required) required @endif>
                            @break

                        @case('number')
                            <input id="{{ $field->field_name }}" type="number" name="fields[{{ $field->field_name }}]"
                                   value="{{ old('fields.'.$field->field_name) }}"
                                   class="{{ $inputClasses }}" @if($field->is_required) required @endif>
                            @break

                        @default
                            <input id="{{ $field->field_name }}" type="text" name="fields[{{ $field->field_name }}]"
                                   value="{{ old('fields.'.$field->field_name) }}"
                                   class="{{ $inputClasses }}" @if($field->is_required) required @endif>
                    @endswitch
                </div>
            @endforeach

            <div class="pt-6">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-transparent bg-amber-500 px-5 py-2.5 text-sm font-semibold text-black shadow-sm hover:bg-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                    Generate Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script flatpickr --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('input[type="text"][id]').forEach((el) => {
            if (el.id.toLowerCase().includes('date')) {
                flatpickr(el, {
                    dateFormat: "d-m-Y",
                    altInput: true,
                    altFormat: "d F Y",
                });
            }
        });
    });
</script>

</body>
</html>
