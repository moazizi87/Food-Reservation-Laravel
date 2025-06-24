@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome') }}</div>

                <div class="card-body">
                    {{ __('به سیستم سفارش غذا خوش آمدید. لطفاً برای ادامه وارد شوید یا ثبت‌نام کنید.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection