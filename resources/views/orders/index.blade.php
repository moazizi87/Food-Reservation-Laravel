@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mb-4">مدیریت سفارشات</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="alert alert-info">
                            هیچ سفارشی برای نمایش وجود ندارد.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>کاربر</th>
                                        <th>مبلغ کل</th>
                                        <th>وضعیت</th>
                                        <th>تغییر وضعیت</th>
                                        <th>تاریخ</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->total_amount) }} تومان</td>
                                            <td>{{ $order->status }}</td>
                                            <td>
                                                <form action="{{ route('orders.status', $order) }}" method="POST" class="d-flex">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-select form-select-sm me-2">
                                                        <option value="pending" @if($order->status == 'pending') selected @endif>در انتظار</option>
                                                        <option value="preparing" @if($order->status == 'preparing') selected @endif>در حال آماده‌سازی</option>
                                                        <option value="ready" @if($order->status == 'ready') selected @endif>آماده تحویل</option>
                                                        <option value="delivered" @if($order->status == 'delivered') selected @endif>تحویل داده شد</option>
                                                        <option value="cancelled" @if($order->status == 'cancelled') selected @endif>لغو شده</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">ثبت</button>
                                                </form>
                                            </td>
                                            <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">جزئیات</a>
                                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این سفارش اطمینان دارید؟');">
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
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 