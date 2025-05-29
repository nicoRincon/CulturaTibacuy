@extends('layouts.app')

@section('content')
<style>
    .verify-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0f4ff, #e1eaff);
    }

    .verify-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
        overflow: hidden;
    }

    .verify-card-header {
        background-color: #4a69bd;
        color: white;
        padding: 1.5rem;
        text-align: center;
        font-size: 1.25rem;
        font-weight: bold;
    }

    .verify-card-body {
        padding: 2rem;
    }

    .verify-button {
        background-color: #4a69bd;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    .verify-button:hover {
        background-color: #3b5998;
    }

    .alert-custom {
        border-left: 5px solid #2ecc71;
        background-color: #eafaf1;
        color: #2d6a4f;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
    }

    p {
        margin-bottom: 1rem;
    }
</style>

<div class="verify-container">
    <div class="verify-card">
        <div class="verify-card-header">
            {{ __('Verify Your Email Address') }}
        </div>

        <div class="verify-card-body">
            @if (session('resent'))
                <div class="alert-custom">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p>{{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="verify-button">
                        {{ __('Click here to request another') }}
                    </button>
                </form>
            </p>
        </div>
    </div>
</div>
@endsection
