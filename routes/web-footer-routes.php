// Routes Footer Loi 25
Route::get('/politique-confidentialite', function () {
    return view('politique');
})->name('privacy-policy');

Route::get('/contact', function () {
    return view('legal.contact');
})->name('contact');

// Rediriger les autres routes vers la politique complète
Route::get('/conditions-utilisation', function () {
    return redirect()->route('privacy-policy')->with('section', 'conditions');
})->name('terms');

Route::get('/avis-collecte', function () {
    return redirect()->route('privacy-policy')->with('section', 'collecte');
})->name('data-collection');

Route::get('/droits-acces', function () {
    return redirect()->route('privacy-policy')->with('section', 'droits');
})->name('access-rights');
