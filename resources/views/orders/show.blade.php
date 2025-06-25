@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    جزئیات سفارش شماره #{{ $order->id }}
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p><strong>وضعیت سفارش:</strong> {{ $order->status }}</p>
                    <p><strong>تاریخ ثبت:</strong> {{ $order->created_at->format('Y/m/d H:i') }}</p>
                    <p><strong>مبلغ نهایی:</strong> {{ number_format($order->total_amount) }} تومان</p>
                    @if($order->notes)
                        <p><strong>یادداشت‌ها:</strong> {{ $order->notes }}</p>
                    @endif

                    <hr>

                    <h5>موارد سفارش:</h5>
                    <ul class="list-group">
                        @foreach($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $item->food->name }}</strong>
                                    <br>
                                    <small>تعداد: {{ $item->quantity }}</small>
                                </div>
                                <span>{{ number_format($item->price * $item->quantity) }} تومان</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">بازگشت</a>
                        @can('delete', $order)
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از لغو این سفارش اطمینان دارید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">لغو سفارش</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 