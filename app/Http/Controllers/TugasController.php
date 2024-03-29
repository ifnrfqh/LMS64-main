<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Pelajaran;
use App\Models\DetailTugas;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTugasRequest;
use App\Http\Requests\UpdateTugasRequest;

class TugasController extends Controller
{
    public function guruIndex($pelajaran)
    {
        $title = 'Tugas';
        $tugass = Tugas::where('id_pelajaran', $pelajaran)->get();
        $pelajaran = Pelajaran::findOrFail($pelajaran);
        return view('guru.tugas.index', compact('title', 'tugass', 'pelajaran'));
    }

    public function siswaIndex($pelajaran)
    {
        $title = 'Tugas';
        $tugass = Tugas::where('id_pelajaran', $pelajaran)->get();
        $pelajaran = Pelajaran::findOrFail($pelajaran);
        return view('siswa.tugas.index', compact('title', 'tugass', 'pelajaran'));
    }

    public function siswaShow($idPelajaran, $idTugas)
    {
        $title = 'Detail Tugas';
        $tugas = Tugas::where('id', $idTugas)->first();
        $pelajaran = Pelajaran::findOrFail($idPelajaran);

        $tugass = Tugas::where('id_pelajaran', $idPelajaran)->get();
        $details = DetailTugas::where('id_tugas', $idTugas)->get();
        // $videos = DetailTugas::where('id_materi', $idTugas)->where('tipe_file', 'video')->get();
        $dokumens = DetailTugas::where('id_tugas', $idTugas)->where('tipe_file', 'dokumen')->get();
        $gambars = DetailTugas::where('id_tugas', $idTugas)->where('tipe_file', 'gambar')->get();

        return view('siswa.tugas.detail', compact('title', 'tugas', 'tugass', 'pelajaran', 'details', 'dokumens', 'gambars'));
    }

    public function show($idPelajaran, $idTugas)
    {
        $tugas = Tugas::where('id', $idTugas)->first();
        $pelajaran = Pelajaran::findOrFail($idPelajaran);
        $details = DetailTugas::where('id_tugas', $idTugas)->get();
        $title = 'Detail Tugas';

        if (auth()->user()->role === 'guru') {
            return view('guru.tugas.detail', compact('title', 'tugas', 'pelajaran', 'details'));
        } else {
            $tugass = Tugas::where('id_pelajaran', $idPelajaran)->get();
            return view('siswa.tugas.detail', compact('title', 'tugas', 'tugass', 'pelajaran', 'details'));
        }
    }

    public function uploadTugas(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $tugas = Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'id_pelajaran' => $request->id_pelajaran,
        ]);

        foreach ($request->file('files') as $file) {
            $namaFile = $file->getClientOriginalName();
            $pathFile = $file->store('tugas');
            $ekstensi = $file->getClientOriginalExtension();
            $tipeFile = $this->getFileType($ekstensi);


            DetailTugas::create([
                'id_tugas' => $tugas->id,
                'nama_file' => $namaFile,
                'path_file' => $pathFile,
                'tipe_file' => $tipeFile,
            ]);
        }

        return redirect()->back()->with('success', 'Tugas berhasil diunggah.');
    }  

    private function getFileType($extension)
    {
        $ekstensiDokumen = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'pptx'];
        $ekstensiGambar = ['jpg', 'jpeg', 'png'];
        // $ekstensiVideo = ['mp4'];

        if (in_array($extension, $ekstensiDokumen)) {
            return 'dokumen';
        } elseif (in_array($extension, $ekstensiGambar)) {
            return 'gambar';
        } else {
            return 'lainnya';
        }
    }

    public function editTugas(Request $request, $pelajaran, $idTugas)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $tugas = Tugas::findOrFail($idTugas);

        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->id_pelajaran = $pelajaran;
        $tugas->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $namaFile = $file->getClientOriginalName();
                $file->storeAs('public/tugas', $namaFile);
                $pathFile = 'storage/tugas/' . $namaFile;

                $ekstensi = $file->getClientOriginalExtension();
                $tipeFile = $this->getFileType($ekstensi);

                $detailTugas = DetailTugas::updateOrCreate(
                    ['id_tugas' => $tugas->id, 'nama_file' => $namaFile],
                    ['path_file' => $pathFile, 'tipe_file' => $tipeFile]
                );
            }
        }

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($pelajaran, $idTugas)
    {
        $tugas = Tugas::find($idTugas);
        $details = DetailTugas::where('id_tugas', $idTugas)->get();

        foreach ($details as $detail) {
            $detail->delete();
        }

        $tugas->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
    }

    public function deleteFile($pelajaran, $idTugas, $idFile)
    {
        $file = DetailTugas::find($idFile);
        $file->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }
}
