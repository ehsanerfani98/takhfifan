@props([
    'name',
    'id' => null,
    'value' => null,
    'multiple' => false,
    'preview' => true
])

@php
    $id = $id ?? $name;
@endphp

<div class="media-picker-component">
    @if($multiple)
        {{-- حالت گالری (چند تصویری) --}}
        <div class="input-group mb-2">
            <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}">
            <button type="button" class="btn btn-outline-danger"
                onclick="openMediaManager('{{ $id }}', true, true)">انتخاب تصاویر</button>
        </div>

        @if($preview)
            <div id="{{ $id }}_preview" class="d-flex flex-wrap gap-2">
                @if($value)
                    @php
                        $urls = json_decode(str_replace('&quot;', '"', $value), true) ?? [];
                    @endphp
                    @foreach($urls as $img)
                        <div class="position-relative d-inline-block">
                            <img src="{{ $img }}" data-src="{{ $img }}" style="max-width:100px;" class="m-1">
                            <button type="button" class="btn btn-danger btn-sm position-absolute"
                                style="top:0; left:0;" onclick="removeGalleryImage(this, '{{ $id }}')">×</button>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    @else
        {{-- حالت تک تصویری --}}
        <div class="input-group">
            <input type="text" id="{{ $id }}" name="{{ $name }}" class="form-control"
                value="{{ $value }}" placeholder="آدرس تصویر انتخاب‌ شده">
            <button type="button" class="btn btn-outline-danger"
                onclick="openMediaManager('{{ $id }}', true, false)">انتخاب تصویر</button>
        </div>

        @if($preview)
            <img id="{{ $id }}_preview" src="{{ $value }}"
                style="max-width:200px; display:{{ $value ? 'block' : 'none' }}; margin-top:10px;"
                class="img-thumbnail">
        @endif
    @endif
</div>

@push('script')
<script>
    function removeGalleryImage(btn, inputId) {
        btn.parentElement.remove();
        updateGalleryInput(inputId);
    }

    function updateGalleryInput(inputId) {
        const previewContainer = document.getElementById(inputId + '_preview');
        const input = document.getElementById(inputId);

        if (previewContainer && input) {
            const urls = Array.from(previewContainer.querySelectorAll('img'))
                .map(img => img.dataset.src);
            input.value = JSON.stringify(urls);
        }
    }

    function openMediaManager(inputId, preview = false, multiple = false) {
        const w = 1000,
            h = 600;
        const left = (window.innerWidth - w) / 2;
        const top = (window.innerHeight - h) / 2 + 80;
        let url = "{{ route('media.manager') }}?input=" + inputId;
        if (multiple) url += "&multiple=1";
        window.open(url, "mediaManager_" + inputId, `scrollbars=yes,width=${w},height=${h},top=${top},left=${left}`);

        function handleMessage(e) {
            if (!e.data.input || e.data.input !== inputId) return;
            window.removeEventListener('message', handleMessage);

            const input = document.getElementById(inputId);
            const previewContainer = document.getElementById(inputId + '_preview');

            /* تصویر شاخص */
            if (!multiple && e.data.url) {
                input.value = e.data.url;

                if (preview && previewContainer) {
                    previewContainer.src = e.data.url;
                    previewContainer.style.display = 'block';
                }
            }

            /* گالری */
            if (multiple && e.data.urls && e.data.urls.length) {
                input.value = JSON.stringify(e.data.urls);

                if (preview && previewContainer) {
                    e.data.urls.forEach(src => {
                        // بررسی تکراری نبودن تصویر
                        if (previewContainer.querySelector(`img[data-src="${src}"]`)) return;

                        const wrapper = document.createElement('div');
                        wrapper.className = 'position-relative d-inline-block';

                        const img = document.createElement('img');
                        img.src = src;
                        img.dataset.src = src;
                        img.style.maxWidth = '100px';
                        img.className = 'm-1';

                        const del = document.createElement('button');
                        del.type = 'button';
                        del.className = 'btn btn-danger btn-sm position-absolute';
                        del.style.top = '0';
                        del.style.left = '0';
                        del.innerHTML = '×';
                        del.onclick = function() {
                            removeGalleryImage(this, inputId);
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(del);
                        previewContainer.appendChild(wrapper);
                    });
                }
            }
        }

        window.addEventListener('message', handleMessage);
    }

    // تابع برای سازگاری با کد موجود
    function removeGalleryImage(btn) {
        const wrapper = btn.parentElement;
        wrapper.remove();
        const urls = Array.from(document.querySelectorAll('#gallery_preview img'))
            .map(img => img.dataset.src);
        document.getElementById('gallery').value = JSON.stringify(urls);
    }
</script>
@endpush