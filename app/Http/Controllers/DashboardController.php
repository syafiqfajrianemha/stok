<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = Transaksi::query();

        if ($filter === 'hari_ini') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === 'minggu_ini') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'bulan_ini') {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter === 'custom' && $tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
        }

        $transaksiFiltered = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $transaksiFiltered->sum('total');

        $chartData = $transaksiFiltered
            ->groupBy(function ($item) use ($filter) {
                if ($filter === 'hari_ini') {
                    return $item->created_at->format('H:i');
                } elseif ($filter === 'minggu_ini') {
                    return $item->created_at->format('l'); // Senin, Selasa, dst
                } elseif ($filter === 'bulan_ini') {
                    return $item->created_at->format('d M');
                } elseif ($filter === 'custom') {
                    return $item->created_at->format('d M');
                }
                return $item->created_at->format('d M');
            })
            ->map(function ($items) {
                return $items->sum('total');
            });

        $barangStokMinimum = Barang::whereColumn('stok', '<=', 'stok_minimum')->get();

        return view('dashboard', compact(
            'transaksiFiltered',
            'totalPendapatan',
            'filter',
            'tanggalAwal',
            'tanggalAkhir',
            'chartData',
            'barangStokMinimum'
        ));
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->input('filter');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $query = Transaksi::query();

        if ($filter === 'hari_ini') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === 'minggu_ini') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'bulan_ini') {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter === 'custom' && $tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
        }

        $transaksiFiltered = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $transaksiFiltered->sum('total');

        $pdf = Pdf::loadView('laporan-dashboard', compact('transaksiFiltered', 'totalPendapatan', 'filter'));
        return $pdf->stream('laporan-dashboard.pdf');
    }
}
