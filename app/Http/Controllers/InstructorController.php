<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstructorController extends Controller
{

    // model data Instructor
    /*
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            // firstName
            $table->string('firstName');
            // lastName
            $table->string('lastName')->nullable()->default(null);
            // enum gender
            $table->enum('gender',['male','female','Other']);
            // birthDate format DD/MM/YYYY
            $table->date('birthDate');
            // address
            $table->string('address');
            // phone
            $table->string('phone');
            // driving Experience
            $table->integer('drivingExperience');
            // certificate
            $table->string('certificate');
            // rating
            $table->float('rating');

            // fk from user
            $table->unsignedBigInteger('userID');
            $table->foreign('id')->references('id')->on('users');

            $table->timestamps();
        });
    */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::all(); // Mengambil semua data instruktur dari database
        return view('instructors.index', compact('instructors')); // Menampilkan daftar instruktur ke tampilan
    }

    /**
     * Menampilkan form untuk membuat instruktur baru.
     */
    public function create()
    {
        // Tampilkan form untuk membuat instruktur baru
        return view('instructors.create');
    }

    public function showProfile(){
        // ambil dari auth
        $instructor = Instructor::where('userID', auth()->user()->id)->first();
        dd($instructor);
        return view('instructor.profile', compact('instructor'));
    }

    /**
     * Menyimpan data instruktur yang baru dibuat ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
        // Validasi data dari form sebelum disimpan
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'nullable|string',
            'gender' => 'required|in:male,female,Other',
            'birthDate' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string',
            'drivingExperience' => 'required|integer',
            'certificate' => 'required|string',
            'rating' => 'required|numeric',
            'userID' => 'required|exists:users,id', // Pastikan user dengan ID yang diberikan ada dalam tabel users
        ]);

        // Simpan data instruktur ke dalam database
        $instructor = Instructor::create($validatedData);

        return redirect()->route('instructors.index')->withStatus('Instruktur berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dari instruktur yang telah dipilih.
     */
    public function show($id)
    {
        // Tampilkan detail instruktur
        $instructor = Instructor::findOrFail($id);
        return view('admin.users', compact('instructor'));
    }


    /**
     * Menampilkan form untuk mengedit data instruktur.
     */
    public function edit(Instructor $Instructor)
    {
        // Tampilkan form edit untuk instruktur yang dipilih
        return view('instructors.edit', compact('Instructor'));
    }

    /**
     * Memperbarui data instruktur dalam penyimpanan.
     */
    public function update(Request $request, Instructor $Instructor)
    {
        // Validasi data dari form sebelum diperbarui
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'nullable|string',
            'gender' => 'required|in:male,female,Other',
            'birthDate' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string',
            'drivingExperience' => 'required|integer',
            'certificate' => 'required|string',
            'rating' => 'required|numeric',
            'userID' => 'required|exists:users,id', // Pastikan user dengan ID yang diberikan ada dalam tabel users
        ]);

        // Perbarui data instruktur
        $Instructor->update($validatedData);

        return redirect()->route('instructors.index')->withStatus('Data instruktur berhasil diperbarui.');
    }

    /**
     * Menghapus data instruktur dari penyimpanan.
     */
    public function destroy(Instructor $instructor)
    {
        // Hapus data instruktur
        $instructor->delete();

        return redirect()->route('instructors.index')->withStatus('Instruktur berhasil dihapus.');
    }
}
