@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ویرایش غذا: {{ $food->name }}</div>
                <div class="card-body">
                    <form action="{{ route('foods.update', $food->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">نام غذا</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $food->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $food->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">قیمت (تومان)</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $food->price) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">دسته‌بندی</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == old('category_id', $food->category_id)) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="preparation_time" class="form-label">زمان آماده‌سازی (دقیقه)</label>
                            <input type="number" class="form-control" id="preparation_time" name="preparation_time" value="{{ old('preparation_time', $food->preparation_time) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">تصویر فعلی</label>
                            @if($food->image)
                                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="img-thumbnail mb-2" width="150">
                            @endif
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="1" @if(old('is_available', $food->is_available)) checked @endif>
                            <label class="form-check-label" for="is_available">
                                موجود است
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">بروزرسانی</button>
                        <a href="{{ route('foods.index') }}" class="btn btn-secondary">بازگشت</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 