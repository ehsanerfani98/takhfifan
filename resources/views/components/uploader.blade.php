@props([
    'name' => 'uploaded_files',
])

<div class="custom-dropzone-wrapper mb-3">
    <div id="dropzone" class="dropzone custom-dropzone text-center"></div>
</div>

<input type="hidden" name="{{ $name }}" id="uploaded-files">

@once
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .dropzone {
            min-height: unset;
            border: none;
            background: none;
            padding: 0;
        }

        .custom-dropzone-wrapper {
            border: 2px dashed #6c757d;
            border-radius: 12px;
            padding: 30px;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease;
        }

        .custom-dropzone .dz-preview {
            width: 100px;
            margin: 20px;
        }

        @media (max-width: 576px) {
            .dropzone .dz-preview {
                width: 30%;
                margin: 8%;
            }
        }

        .dz-remove {
            color: red !important;
            cursor: pointer;
        }
    </style>
@endonce

@push('scripts')
    <script>
        Dropzone.autoDiscover = false;

        const uploadedFiles = [];
        const dz = new Dropzone("#dropzone", {
            url: "{{ route('upload.temporary.file') }}", // روت برای آپلود موقت
            paramName: "file",
            maxFiles: 3,
            maxFilesize: 10, // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            dictRemoveFile: "حذف",
            dictDefaultMessage: "فایل ها را در اینجا رها کنید یا کلیک کنید",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },

            success: function(file, response) {
                uploadedFiles.push(response.path);
                updateHiddenInput();
                file._serverPath = response.path;
            },

            removedfile: function(file) {
                let index = uploadedFiles.indexOf(file._serverPath);
                if (index > -1) {
                    uploadedFiles.splice(index, 1);
                    updateHiddenInput();
                }
                let preview = file.previewElement;
                if (preview) {
                    preview.parentNode.removeChild(preview);
                }
            },

            error: function(file, message) {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: typeof message === 'string' ? message : 'آپلود فایل با خطا مواجه شد',
                });
            },

            maxfilesexceeded: function(file) {
                this.removeFile(file);
                Swal.fire({
                    icon: 'error',
                    title: 'تعداد فایل‌ها بیشتر از حد مجاز است',
                    text: 'حداکثر ۳ فایل می‌ توانید آپلود کنید',
                });
            }
        });

        function updateHiddenInput() {
            document.getElementById('uploaded-files').value = JSON.stringify(uploadedFiles);
        }
    </script>
@endpush
