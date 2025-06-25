@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">تاریخچه سفارشات من</h1>

            <div class="card">
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="alert alert-info">
                            شما تاکنون هیچ سفارشی ثبت نکرده‌اید.
                        </div>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>تاریخ ثبت</th>
                                    <th>مبلغ کل</th>
                                    <th>وضعیت</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                                        <td>{{ number_format($order->total_amount) }} تومان</td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">مشاهده جزئیات</a>
                                            @can('delete', $order)
                                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از لغو این سفارش اطمینان دارید؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">لغو سفارش</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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