<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ویرایش غذا') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('foods.update', $food) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('دسته‌بندی')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('انتخاب کنید') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $food->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('نام')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $food->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('توضیحات')" />
                            <x-textarea-input id="description" class="block mt-1 w-full" name="description">{{ old('description', $food->description) }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="price" :value="__('قیمت')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $food->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image" :value="__('تصویر')" />
                            @if($food->image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}" class="h-32 w-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <x-file-input id="image" class="block mt-1 w-full" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="preparation_time" :value="__('زمان آماده‌سازی (دقیقه)')" />
                            <x-text-input id="preparation_time" class="block mt-1 w-full" type="number" name="preparation_time" :value="old('preparation_time', $food->preparation_time)" required />
                            <x-input-error :messages="$errors->get('preparation_time')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="is_available" class="inline-flex items-center">
                                <input id="is_available" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_available" value="1" {{ old('is_available', $food->is_available) ? 'checked' : '' }}>
                                <span class="mr-2 text-sm text-gray-600">{{ __('موجود') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" type="button" class="ml-4">
                                {{ __('انصراف') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('ذخیره') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 