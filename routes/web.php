<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PengajuanMagangController;
use App\Http\Controllers\TemplateController;

require_once __DIR__ . '/auth.php';

Route::name('guest.')
    ->group(function () {
        Route::view('/', 'pages.guest.landing-page')->name('landing-page');
        Route::view('pengembang', 'pages.guest.pengembang')->name('pengembang');
        Route::view('tata-tertib', 'pages.guest.tata-tertib')->name('tata-tertib');

        Route::view('cara-magang', 'pages.guest.cara-magang')->name('cara-magang');

        Route::view('tips-memilih-magang', 'pages.guest.tips-memilih-magang')->name('tips-memilih-magang');
    });

Route::middleware('role:admin,mahasiswa,dosen')
    ->group(function () {
        Volt::route('dashboard', 'pages.user.dashboard')->name('dashboard');
        Volt::route('profile', 'pages.user.profile')->name('profile');

        Route::get('template/pdf/{file_name}', [TemplateController::class, 'previewFile'])->name('template-view');
    });

Route::name('admin.')
    ->middleware('role:admin')
    ->group(function () {

        Route::prefix('kelola-data-pengguna')
            ->group(function () {
                Volt::route('data-mahasiswa', 'pages.admin.kelola-data-pengguna.data-mahasiswa')->name('data-mahasiswa');
                Volt::route('detail-mahasiswa/{id}', 'pages.admin.kelola-data-pengguna.detail-mahasiswa')->name('detail-mahasiswa');

                Volt::route('data-dosen', 'pages.admin.kelola-data-pengguna.data-dosen')->name('data-dosen');
                Volt::route('detail-dosen/{id}', 'pages.admin.kelola-data-pengguna.detail-dosen')->name('detail-dosen');

                Volt::route('data-perusahaan', 'pages.admin.kelola-data-pengguna.data-perusahaan')->name('data-perusahaan');
                Volt::route('detail-perusahaan/{id}', 'pages.admin.kelola-data-pengguna.detail-perusahaan')->name('detail-perusahaan');
            });


        Route::prefix('magang')
            ->group(function () {
                Volt::route('data-lowongan', 'pages.admin.magang.data-lowongan')->name('data-lowongan');
                Volt::route('detail-lowongan/{id}', 'pages.admin.magang.detail-lowongan')->name('detail-lowongan');

                Volt::route('data-pengajuan-magang', 'pages.admin.magang.data-pengajuan')->name('data-pengajuan-magang');
                Volt::route('detail-pengajuan/{id}', 'pages.admin.magang.detail-pengajuan')->name('detail-pengajuan');

                Route::view('statistik-magang', 'pages.admin.magang.statistik-magang')->name('statistik-magang');
                Route::view('perusahaan-terpopuler', 'pages.admin.magang.perusahaan-terpopuler')->name('perusahaan-terpopuler');

                Route::view('aturan-magang', 'pages.admin.magang.aturan-magang')->name('aturan-magang');
                Volt::route('data-lowongan-diperbarui', 'pages.admin.magang.data-pengajuan-diperbarui')->name('data-pengajuan-diperbarui');
                Volt::route('detail-pengajuan-diperbarui/{id}', 'pages.admin.magang.detail-pengajuan-diperbarui')->name('detail-pengajuan-diperbarui');
            });


        Volt::route('laporan-statistik-magang', 'pages.admin.laporan-statistik-magang')->name('laporan-statistik-magang');
        Route::view('evaluasi-sistem-rekomendasi', 'pages.admin.evaluasi-sistem')->name('evaluasi-sistem-rekomendasi');
    });


Route::name('mahasiswa.')
    ->middleware('role:mahasiswa')
    ->group(function () {
        Volt::route('persiapan', 'pages.mahasiswa.persiapan-preferensi')->name('persiapan-preferensi');

        Volt::route('pengajuan-magang', 'pages.mahasiswa.pengajuan-magang.pengajuan-magang')->name('pengajuan-magang');
        Volt::route('formulir-pengajuan', 'pages.mahasiswa.pengajuan-magang.formulir-pengajuan')->name('form-pengajuan-magang');
        Route::post('formulir-pengajuan', [PengajuanMagangController::class, 'storePengajuan'])->name('store-pengajuan-magang');

        Route::view('konsul-dospem', 'pages.mahasiswa.konsul-dospem')->name('konsul-dospem');

        Volt::route('pembaruan-status', 'pages.mahasiswa.pembaruan-status')->name('pembaruan-status');
        Volt::route('log-mahasiswa', 'pages.mahasiswa.log-mahasiswa')->name('log-mahasiswa');
        Volt::route('search', 'pages.mahasiswa.search')->name('search');
        Route::view('detail-perusahaan', 'pages.mahasiswa.detail-perusahaan')->name('detail-perusahaan');
        Route::view('notifikasi', 'pages.mahasiswa.notifikasi')->name('notifikasi');
        Route::view('profil-perusahaan', 'pages.mahasiswa.profil-perusahaan')->name('profil-perusahaan');
        Volt::route('detail-log', 'pages.mahasiswa.detail-log')->name('detail-log');
        Volt::route('log-magang', 'pages.mahasiswa.log-magang')->name('log-magang');
        Volt::route('tambah-log', 'pages.mahasiswa.tambah-log')->name('tambah-log');

        Volt::route('pencarian', 'pages.mahasiswa.hasil-pencarian')->name('hasil-pencarian');
        Volt::route('detail-perusahaan', 'pages.mahasiswa.detail-perusahaan')->name('detail-perusahaan');
        Volt::route('profil-perusahaan', 'pages.mahasiswa.profil-perusahaan')->name('profil-perusahaan');

        Route::view('notifikasi', 'pages.mahasiswa.notifikasi')->name('notifikasi');
        Volt::route('riwayat-rekomendasi', 'pages.mahasiswa.riwayat-rekomendasi.index')->name('riwayat-rekomendasi');
        Volt::route('riwayat-rekomendasi/detail', 'pages.mahasiswa.riwayat-rekomendasi.detail-rekomendasi')->name('detail-rekomendasi');
        Volt::route('saran-dari-dosen', 'pages.mahasiswa.saran-dari-dosen')->name('saran-dari-dosen');
    });

Route::name('dosen.')
    ->middleware('role:dosen')
    ->group(function () {
        Volt::route('/mahasiswa-bimbingan', 'pages.dosen.mahasiswa-bimbingan')->name('mahasiswa-bimbingan');
        Volt::route('/mahasiswa-bimbingan/{id}', 'pages.dosen.detail-mahasiswa-bimbingan')->name('detail-mahasiswa-bimbingan');
        Route::view('/komunikasi', 'pages.dosen.komunikasi-mahasiswa')->name('komunikasi');
        Route::view('/komunikasi/mahasiswa', 'pages.dosen.masukan-magang')->name('komunikasi-mahasiswa');
    });
