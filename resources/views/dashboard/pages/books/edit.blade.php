@extends('dashboard.main')

@section('container')
<select x-cloak id="select" class="hidden">
    <option value="1">Scifi</option>
    <option value="2">Horor</option>
    <option value="3">Romance</option>
    <option value="4">Comedy</option>
  </select>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Add Book
        </h2>

        {{-- form --}}
        <form action="/books/{{ $oldData->id() }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="px-8 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                  <label class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Cover</span>
                        <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="link cover buku" type="text" name="cover" id="cover" value="{{ old('cover' , $oldData->data()['cover']) }}" required
                        />
                        @error('cover')
                            <div class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                {{ $message }}
                            </div>
                        @enderror
                    
                  </label>

                  <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">Judul</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Judul buku" type="text" name="judul" id="judul" value="{{ old('judul', $oldData->data()['judul']) }}" required/>
                    @error('judul')
                        <div class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{ $message }}
                        </div>
                    @enderror
                  </label>
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Pengarang</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Nama Pengarang" type="text" name="pengarang" id="pengarang" value="{{ old('pengarang' , $oldData->data()['pengarang']) }}" required
                    />
                    @error('pengarang')
                        <div class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{ $message }}
                        </div>
                    @enderror
                  </label>
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Tahun terbit</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Tahun terbit" type="number" name="tahun" id="tahun"  value="{{ old('tahun' , $oldData->data()['tahun_terbit']) }}" required
                    />
                    @error('tahun')
                        <div class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{ $message }}
                        </div>
                    @enderror
                  </label>
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Stok</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Stok buku" type="number" name="stok" id="stok" value="{{ old('stok' , $oldData->data()['stok']) }}" required
                    />
                    @error('stok')
                        <div class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{ $message }}
                        </div>
                    @enderror
                  </label>

                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Sinopsis</span>
                    <textarea
                      class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="sinopsis" id="sinopsis" rows="3" placeholder="Enter some long form content." 
                    >{{ old('sinopsis' , $oldData->data()['sinopsis']) }}</textarea>
                    @error('sinopsis')
                        <div class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{ $message }}
                        </div>
                    @enderror
                  </label>

                <button class="flex items-center justify-between mt-6 px-10 py-4 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" type="submit">
                    <svg
                    class="w-4 h-4 mr-2 -ml-1"
                    fill="currentColor"
                    aria-hidden="true"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                      clip-rule="evenodd"
                      fill-rule="evenodd"
                    ></path>
                  </svg>
                 <span>Larger button</span>
                </button>
            </div>
        </form>
    </div>
</main>
@endsection