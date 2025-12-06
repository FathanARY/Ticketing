<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CashPaymentController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfileController;
use App\Models\Speaker;
use App\Models\Event;

Route::get('/', function () {
    $speaker = Speaker::first();
    
    $events = Event::orderBy('event_id', 'asc')->get();

    return view('home', compact('speaker', 'events'));
})->name('home');

Route::middleware('guest')->group(function () {

    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('login', [AuthController::class, 'loginStore'])->name('login.post');

    Route::get('register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('register', [AuthController::class, 'registerStore'])->name('register.post');

    // Forgot Password Routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.send-code');
    Route::get('verify-code', [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify.post');
    Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});


Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

   Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect(route('admin.dashboard'));
        }

        

        // 1. Data untuk Menu TICKET
        $tickets = DB::table('cash_payments')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Data untuk Menu HOME (Baru)
        $speaker = Speaker::first();
        $events = Event::orderBy('event_id', 'asc')->get();

        return view('dashboard', compact('tickets', 'speaker', 'events'));
    })->name('dashboard');
    Route::get('/admin/dashboard', function () {
        if (Auth::user()->role != 'admin') {
            return redirect(route('dashboard'));
        }
        return view('admin.admin_dashboard');
    })->name('admin.dashboard');

    Route::get('/user/home', function () {
        $speaker = App\Models\Speaker::first();
        $events = App\Models\Event::orderBy('event_id', 'asc')->get();

        return view('home', compact('speaker', 'events'));
    })->name('home.user');

    // Ticket Dashboard Routes
    Route::get('/ticket/dashboard', [PaymentController::class, 'dashboard'])->name('ticket.dashboard');
    Route::post('/ticket/order', [PaymentController::class, 'order'])->name('ticket.order');

    // User Ticket Proof
    Route::get('/my-tickets/{payment_id}/proof', [PaymentController::class, 'userTicketProof'])->name('user.ticket.proof');

    // Cash Payment Routes
    Route::post('/ticket/cash/prepare', [PaymentController::class, 'cashPrepare'])->name('ticket.cash.prepare');
    Route::post('/ticket/cash/submit', [PaymentController::class, 'cashSubmit'])->name('ticket.cash.submit');
    Route::get('/ticket/cash/pending', [PaymentController::class, 'cashPending'])->name('ticket.cash.pending');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Rute Talkshow
    Route::get('/ticket/talkshow', [PaymentController::class, 'talkshowForm'])->name('ticket.talkshow');
    Route::post('/ticket/talkshow', [PaymentController::class, 'talkshowSubmit'])->name('ticket.talkshow.submit');

    // Rute Tryout
    Route::get('/ticket/dashboard', [PaymentController::class, 'tryoutForm'])->name('ticket.dashboard');
    
});

Route::post('/midtrans/callback', [TicketController::class, 'callback'])->name('midtrans.callback');


// Admin Routes - Tickets
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('admin.tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('admin.tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');
});

// Admin Routes - Events
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{event_id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{event_id}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event_id}', [EventController::class, 'destroy'])->name('admin.events.destroy');
});

// Admin Routes - Users
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user_id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user_id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user_id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Admin Routes - Cash Payments
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/cash-payments', [CashPaymentController::class, 'index'])->name('admin.cash.payments');
    Route::get('/cash-payments/{payment_id}/proof', [CashPaymentController::class, 'showProof'])->name('admin.cash.proof');
    Route::post('/cash-payments/{payment_id}/approve', [CashPaymentController::class, 'approve'])->name('admin.cash.approve');
    Route::post('/cash-payments/{payment_id}/reject', [CashPaymentController::class, 'reject'])->name('admin.cash.reject');
});

// Google
Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('google.callback');

// Facebook
Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback'])->name('facebook.callback');
