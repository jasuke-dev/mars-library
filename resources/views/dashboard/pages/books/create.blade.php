@extends('dashboard.main')

@section('container')
<select x-cloak id="select" class="hidden">
    <option value="1">Option 2</option>
    <option value="2">Option 3</option>
    <option value="3">Option 4</option>
    <option value="4">Option 5</option>
  </select>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Add Book
        </h2>

        {{-- form --}}
        <form action="/books" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-8 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block mt-4 text-sm">
                        <div class="flex w-64">
                            <label x-data="showImage()" class="flex flex-col w-64 h-96 border-4 border-dashed hover:bg-gray-100 hover:border-gray-300">
                                <div class="relative flex flex-col items-center justify-center pt-7">
                                    <img id="preview" class="absolute inset-0 w-full h-96">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-12 h-12 text-gray-400 group-hover:text-gray-600 mt-28" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                        Select a photo</p>
                                </div>
                                <input name="cover" id="cover" type="file" class="opacity-0" accept="image/*" @change="showPreview(event)" />
                            </label>
                        </div>
                    
                  </label>

                  <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">Judul</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Judul buku" type="text" name="judul" id="judul"
                    />
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </label>
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Pengarang</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Nama Pengarang" type="text" name="pengarang" id="pengarang"
                    />
                  </label>
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Tahun terbit</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Tahun terbit" type="number" name="tahun" id="tahun"
                    />
                  </label>
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Stok</span>
                    <input
                      class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                      placeholder="Tahun terbit" type="number" name="stok" id="stok"
                    />
                  </label>
                     
                  <label class="block mt-4 text-sm" x-data="dropdown()" x-init="loadOptions()">
                    <span class="text-grey-700 dark:text-gray-400">multiple</span>
                    <input name="values" type="hidden" x-bind:value="selectedValues()">
                    <div class="w-full">
                        <div class="flex flex-col items-center relative">
                            <div x-on:click="open" class="w-full  svelte-1l8159u">
                                <div class="my-2 p-1 flex border border-gray-200 bg-white rounded svelte-1l8159u">
                                    <div class="flex flex-auto flex-wrap">
                                        <template x-for="(option,index) in selected" :key="options[option].value">
                                            <div
                                                class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-purple-700 bg-purple-100 border border-purple-300 ">
                                                <div class="text-xs font-normal leading-none max-w-full flex-initial x-model="
                                                    options[option]" x-text="options[option].text"></div>
                                                <div class="flex flex-auto flex-row-reverse">
                                                    <div x-on:click="remove(index,option)">
                                                        <svg class="fill-current h-6 w-6 " role="button" viewBox="0 0 20 20">
                                                            <path d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                                       c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                                       l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                                       C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                                        </svg>
            
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <div x-show="selected.length    == 0" class="flex-1">
                                            <input placeholder="Select a option"
                                                class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800"
                                                x-bind:value="selectedValues()"
                                            >
                                        </div>
                                    </div>
                                    <div
                                        class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u">
            
                                        <button type="button" x-show="isOpen() === true" x-on:click="open"
                                            class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                            <svg version="1.1" class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83 c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25 L17.418,6.109z" />
                                            </svg>
            
                                        </button>
                                        <button type="button" x-show="isOpen() === false" @click="close"
                                            class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                <path d="M2.582,13.891c-0.272,0.268-0.709,0.268-0.979,0s-0.271-0.701,0-0.969l7.908-7.83 c0.27-0.268,0.707-0.268,0.979,0l7.908,7.83c0.27,0.268,0.27,0.701,0,0.969c-0.271,0.268-0.709,0.268-0.978,0L10,6.75L2.582,13.891z" />
                                            </svg>
            
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full px-4">
                                <div x-show.transition.origin.top="isOpen()"
                                    class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj"
                                    x-on:click.away="close">
                                    <div class="flex flex-col w-full">
                                        <template x-for="(option,index) in options" :key="option">
                                            <div>
                                                <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-purple-100"
                                                    @click="select(index,$event)">
                                                    <div x-bind:class="option.selected ? 'border-purple-600' : ''"
                                                        class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                                        <div class="w-full items-center flex">
                                                            <div class="mx-2 leading-6" x-model="option" x-text="option.text"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                </label>

                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Sinopsis</span>
                    <textarea
                      class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="sinopsis" id="sinopsis"
                      rows="3"
                      placeholder="Enter some long form content."
                    ></textarea>
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