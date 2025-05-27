<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, usesPagination, with};
use Illuminate\Database\Eloquent\Builder;
use App\Models\Perusahaan;

layout('components.layouts.admin.main');

state([
    'totalRowsPerPage' => 10,
    'data_perusahaan' => [],
]);

state([
    'totalRowsPerPage' => 10,
    'statusInsertSingleData' => '',
    'storePerusahaanNama' => null,
    'storePerusahaanLokasi' => null,
    'storePerusahaanBidangIndustri' => null,
    'storePerusahaanKategori' => null
]);

usesPagination();

with(function () {
    return [
        'dataPerusahaan' => Perusahaan::select('id', 'nama', 'bidang_industri')
            ->withCount([
                'magang as jumlah_mahasiswa_magang' => function (Builder $query) {
                    $query->join('kontrak_magang', 'magang.id', '=', 'kontrak_magang.magang_id');
                },
            ])
            ->orderBy('jumlah_mahasiswa_magang', 'desc')
            ->paginate($this->totalRowsPerPage),
    ];
});

$storeSingleData = function (): void {
    $perusahaan = Perusahaan::create([
        'nama' => $this->storePerusahaanNama,
        'lokasi' => $this->storePerusahaanLokasi,
        'bidang_industri' => $this->storePerusahaanBidangIndustri,
        'kategori' => $this->storePerusahaanKategori,

    ]);

    $this->statusInsertSingleData = $perusahaan ? 'success' : 'failed';
    Flux::modal('add-new-data')->close();

    if ($perusahaan) {
        Flux::modal('success-submit-form')->show();
    } else {
        Flux::modal('failed-submit-form')->show();
    }
};

$goToSpecificPage = fn(int $page) => $this->setPage($page);
$goToPrevPage = fn() => $this->previousPage();
$goToNextPage = fn() => $this->nextPage();

?>

<div class="flex flex-col gap-5">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item class="text-black">Kelola Data Perusahaan
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Kelola Data Perusahaan</h1>

    <div class="flex justify-between">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Perusahaan" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
        <div class="flex gap-3">
            <flux:modal.trigger name="add-new-data">
                <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus">Tambah Perusahaan</flux:button>
            </flux:modal.trigger>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="download">Import</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="upload">Export</flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Nama</th>
                    <th class="text-left px-6 py-3">Bidang Industri</th>
                    <th class="text-left px-6 py-3">Jumlah Mahasiswa Magang</th>
                    <th class="text-center px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($dataPerusahaan as $perusahaan)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $perusahaan['nama'] }}</td>
                        <td class="px-6 py-3">{{ $perusahaan['bidang_industri'] }}</td>
                        <td class="px-6 py-3">{{ $perusahaan['jumlah_mahasiswa_magang'] }}</td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="chevron-right" href="{{ route('admin.detail-perusahaan') }}"
                                variant="ghost" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <div class="text-black">
                <p>Menampilkan {{ $dataPerusahaan->count() }} dari {{ $dataPerusahaan->perPage() }} data</p>
            </div>
            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" />
                @for ($i = 0; $i < $dataPerusahaan->lastPage(); $i++)
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $i + 1 }})">{{ $i + 1 }}
                    </flux:button>
                @endfor
                <flux:button icon="chevron-right" variant="ghost" wire:click="goToNextPage" />
            </div>
            <div class="flex gap-3 items-center text-black">
                <p>Baris per halaman</p>
                <flux:select class="w-20!" wire:model.live="totalRowsPerPage">
                    <flux:select.option>10</flux:select.option>
                    <flux:select.option>25</flux:select.option>
                    <flux:select.option>50</flux:select.option>
                    <flux:select.option>100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>


    <flux:modal name="add-new-data" class="md:w-96">
        <form wire:submit="storeSingleData" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambahkan data perusahaan baru</flux:heading>
            </div>

            <flux:input label="Nama" placeholder="Nama perusahaan" wire:model="storePerusahaanNama" />
            <flux:input label="Lokasi" placeholder="Lokasi" wire:model="storePerusahaanLokasi" />

            <flux:field>
                <flux:label>Bidang Industri</flux:label>
                <flux:select placeholder="Bidang industri perusahaan" wire:model="storePerusahaanBidangIndustri">
                    <flux:select.option value="Perbankan">Perbankan</flux:select.option>
                    <flux:select.option value="Kesehatan">Kesehatan</flux:select.option>
                    <flux:select.option value="Pendidikan">Pendidikan</flux:select.option>
                    <flux:select.option value="E-Commerce">E-Commerce</flux:select.option>
                    <flux:select.option value="Telekomunikasi">Telekomunikasi</flux:select.option>
                    <flux:select.option value="Transportasi">Transportasi</flux:select.option>
                    <flux:select.option value="Pemerintahan">Pemerintahan</flux:select.option>
                    <flux:select.option value="Manufaktur">Manufaktur</flux:select.option>
                    <flux:select.option value="Energi">Energi</flux:select.option>
                    <flux:select.option value="Media">Media</flux:select.option>
                    <flux:select.option value="Teknologi">Teknologi</flux:select.option>
                    <flux:select.option value="Agrikultur">Agrikultur</flux:select.option>
                    <flux:select.option value="Pariwisata">Pariwisata</flux:select.option>
                    <flux:select.option value="Keamanan">Keamanan</flux:select.option>
                </flux:select>
                <flux:error name="bidang_industri" />
            </flux:field>

            <flux:field>
                <flux:label>Kategori Relasi</flux:label>
                <flux:select placeholder="Kategori relasi perusahaan" wire:model="storePerusahaanKategori">
                    <flux:select.option value="mitra">Mitra</flux:select.option>
                    <flux:select.option value="non_mitra">Non-Mitra</flux:select.option>
                </flux:select>
                <flux:error name="kategori" />
            </flux:field>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="success-submit-form">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Sukses menambahkan data perusahaan!</flux:heading>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">OK</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="failed-submit-form">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Gagal menambahkan data perusahaan!</flux:heading>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">OK</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
