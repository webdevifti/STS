@extends('layouts.master')
@section('title', 'Create A Tickets')
@section('styles')
    <style>

        .dropzone-wrapper {
            border: 2px dashed #91b0b3;
            color: #92b0b3;
            position: relative;
            height: 150px;
            background-color: #eee;
        }

        .dropzone-desc {
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            text-align: center;
            width: 40%;
            top: 50px;
            font-size: 16px;
        }

        .dropzone,
        .dropzone:focus {
            position: absolute;
            outline: none !important;
            width: 100%;
            height: 150px;
            cursor: pointer;
            opacity: 0;
        }

        .dropzone-wrapper:hover,
        .dropzone-wrapper.dragover {
            background: #ecf0f5;
        }
    </style>
@endsection
@section('main_content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Create A Tickets</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Tickets</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-primary btn-sm">My Tickets</a>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card p-2">
                    <div class="card-body">
                        <form action="{{ route('customer.tickets.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label for=""><strong>Title</strong></label>
                                <input type="text" name="title" placeholder="Title" value="{{ old('title') }}"
                                    class="form-control" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Message</strong></label>
                                <textarea cols="30" rows="5" name="message" placeholder="Message" class="form-control" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Labels/Tags</strong></label><br>
                                @foreach ($labels as $key => $label)
                                    <input type="checkbox" id="bug{{ $key }}" name="label[]"
                                        value="{{ $label->name }}">
                                    <label for="bug{{ $key }}">{{ $label->name }}</label>
                                @endforeach
                                @error('label')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Category</strong> </label><br>

                                @foreach ($categories as $k => $category)
                                    <input type="radio" name="category" id="category{{ $k }}"
                                        value="{{ $category->id }}">
                                    <label for="category{{ $k }}">{{ $category->name }}</label>
                                @endforeach
                                @error('category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for=""><strong>Priority</strong></label><br>

                                <input type="radio" name="priority" value="low" id="low">
                                <label for="low">Low</label>
                                <input type="radio" name="priority" value="medium" id="medium">
                                <label for="medium">Medium</label>
                                <input type="radio" name="priority" value="high" id="high">
                                <label for="high">High</label>
                                @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <label for=""><strong>Files (Optional)</strong></label>
                            <small>supported [jpg,png,jpeg] max-size: 10MB</small>
                            <div class="mb-3">
                                @error('image.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="bi bi-cloud-upload-fill"></i>
                                        <p>Choose an image file or drag it here.</p>
                                        <p class="file-count mt-2">No files selected</p>

                                    </div>

                                    <input type="file" name="image[]" accept="image/png, image/jpg, image/jpeg" class="dropzone" multiple>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove d-none text-center"
                                    onclick="resetInput()">Clear</button>
                            </div>
                            <div class="mb-2">

                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        function readFile(input) {
            if (input.files && input.files.length > 0) {
                var wrapperZone = $(input).parent();
                var previewZone = wrapperZone.parent().find('.preview-zone');
                var fileCountDisplay = wrapperZone.parent().find('.file-count');
                var resetButton = wrapperZone.parent().find('.remove');

                wrapperZone.removeClass('dragover');

                var totalFiles = input.files.length;
                fileCountDisplay.text(totalFiles + ' file(s) selected');

                resetButton.removeClass('d-none');
            } else {
                var fileCountDisplay = $(input).parent().parent().find('.file-count');
                fileCountDisplay.text('No files selected');
            }
        }

        function resetInput() {
            var fileInput = $(".dropzone");
            var resetButton = $(".remove");
            fileInput.val(''); 
            var fileCountDisplay = $('.file-count');
            fileCountDisplay.text('No files selected');
            resetButton.addClass('d-none');
        }

        $(".dropzone").change(function() {
            readFile(this);
        });

        $('.dropzone-wrapper').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        $('.dropzone-wrapper').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });
    </script>
@endsection
