@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h2">مدیریت غذاها</h1>
                        <a href="{{ route('foods.create') }}" class="btn btn-success">افزودن غذای جدید</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>دسته‌بندی</th>
                                    <th>قیمت</th>
                                    <th>وضعیت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($foods as $food)
                                    <tr>
                                        <td>{{ $food->id }}</td>
                                        <td>{{ $food->name }}</td>
                                        <td>{{ $food->category->name }}</td>
                                        <td>{{ number_format($food->price) }} تومان</td>
                                        <td>{{ $food->is_available ? 'موجود' : 'ناموجود' }}</td>
                                        <td>
                                            <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-sm btn-warning">ویرایش</a>
                                            <form action="{{ route('foods.destroy', $food->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این غذا اطمینان دارید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 