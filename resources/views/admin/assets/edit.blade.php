@extends('layouts.app')
@section('content')
    <main class="md:col-span-9 lg:col-span-10 md:px-4">
        <div class="flex justify-between flex-wrap md:flex-nowrap items-center pt-3 pb-2 mb-3 border-b dark:text-white">
            <h1 class="text-3xl font-bold">Edit Asset</h1>
        </div>

        <div class="flex flex-wrap">
            <form class="w-full md:w-2/3" method="POST" action="{{ route('assets.update', $asset['id']) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if ($errors->has('message'))
                    <div class="alert alert-danger">
                        {{ $errors->first('message') }}
                    </div>
                @endif

                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Asset Name
                    </label>
                    <input type="text" id="name" name="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Asset Name" value="{{ $asset['name'] }}" />
                    @error('name')
                        <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Asset Type
                    </label>
                    <input type="text" id="type" name="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Class / tools / Sound / Cable" value="{{ $asset['type'] }}" />
                    @error('type')
                        <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Description
                    </label>
                    <input class="dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        id="description" type="hidden" name="description" value="{{ $asset['description'] }}">
                    <trix-editor input="description"
                        class="dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></trix-editor>
                    @error('description')
                        <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload
                        Image</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="image" type="file" name="image" accept=".jpg, .png, .jpeg"
                        value="{{ $asset['original_image'] }}" onchange="previewImage(event)">
                    @error('image')
                        <div class="text-red-500 text-lg ms-2"><small>{{ $message }}</small></div>
                    @enderror

                    <!-- Tampilkan pratinjau gambar dan nama file -->
                    @if (isset($asset['url_image']))
                        <div class="mt-4" id="current-image">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Current Image:</p>
                            <img src="{{ $asset['url_image'] }}" alt="{{ $asset['original_image'] }}"
                                class="w-32 h-32 object-cover mt-2">
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $asset['original_image'] }}</p>
                        </div>
                    @endif
                    <div class="mt-4" id="image-preview" style="display: none;">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">New Image Preview:</p>
                        <img id="preview" class="w-32 h-32 object-cover mt-2">
                        <button type="button" class="mt-2 text-red-600 dark:text-red-500 hover:underline"
                            onclick="cancelImageChange()">Cancel Image Change</button>
                    </div>
                </div>


                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('trix-fill-accept', function(e) {
            e.preventDefault()
        })

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                document.getElementById('image-preview').style.display = 'block';
                document.getElementById('current-image').style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function cancelImageChange() {
            document.getElementById('image').value = ''; // Clear file input
            document.getElementById('image-preview').style.display = 'none';
            document.getElementById('current-image').style.display = 'block';
        }
    </script>
@endpush
