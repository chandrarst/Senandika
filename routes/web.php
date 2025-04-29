<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard.index')->name('dashboard');
Route::view('/medication', 'dashboard.medication')->name('medication');
Route::view('/chatbot', 'dashboard.chatbot')->name('chatbot');
Route::view('/emergency', 'dashboard.emergency')->name('emergency');
Route::view('/location', 'dashboard.location')->name('location');
Route::view('/consultation', 'dashboard.consultation')->name('consultation');
Route::view('/profile', 'dashboard.profile')->name('profile');