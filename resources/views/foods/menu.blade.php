@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mb-4 text-center">منوی غذا</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                
                @if($categories->isEmpty())
                    <div class="alert alert-info text-center">
                        در حال حاضر هیچ غذایی در منو موجود نیست.
                    </div>
                @else
                    @foreach ($categories as $category)
                        @if($category->foods->isNotEmpty())
                            <div class="mb-5">
                                <h2 class="mb-3">{{ $category->name }}</h2>
                                <hr>
                                <div class="row">
                                    @foreach ($category->foods as $food)
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                @if ($food->image)
                                                    <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->name }}" style="height: 200px; object-fit: cover;">
                                                @else
                                                    <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top" alt="No image" style="height: 200px; object-fit: cover;">
                                                @endif
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title">{{ $food->name }}</h5>
                                                    <p class="card-text">{{ Str::limit($food->description, 100) }}</p>
                                                    <p class="card-text mt-auto"><strong>قیمت: {{ number_format($food->price) }} تومان</strong></p>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="input-group">
                                                        <input type="hidden" name="items[{{ $food->id }}][food_id]" value="{{ $food->id }}">
                                                        <input type="number" name="items[{{ $food->id }}][quantity]" class="form-control" placeholder="تعداد" min="0" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="mb-3">
                        <label for="notes" class="form-label">یادداشت‌های سفارش (اختیاری)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">ثبت نهایی سفارش</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection 