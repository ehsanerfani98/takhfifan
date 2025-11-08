@props(['name', 'id' => 'editor_' . uniqid(), 'value' => '', 'direction' => 'rtl'])
<div {{ $attributes }}>
    <div id="{{ $id }}" class="quill-editor mb-2" style="direction: {{ $direction }};"></div>
    <input type="hidden" name="{{ $name }}" id="{{ $id }}_input" value="{!! $value !!}">
</div>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            text-align: right;
            direction: rtl;
        }

        .ql-editor.ql-direction-rtl {
            direction: rtl;
            text-align: right;
        }

        .ql-editor.ql-direction-ltr {
            direction: ltr;
            text-align: left;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editorEl = document.getElementById('{{ $id }}');
            const inputEl = document.getElementById('{{ $id }}_input');

            const DirectionStyle = Quill.import('attributors/style/direction');
            const AlignStyle = Quill.import('attributors/style/align');
            Quill.register(DirectionStyle, true);
            Quill.register(AlignStyle, true);

            const quill = new Quill(editorEl, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['code-block'],
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        [{
                            'align': []
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image'],
                        ['clean'],
                    ]
                },
                placeholder: 'متن خود را وارد کنید...',
                direction: '{{ $direction }}'
            });

            if (inputEl.value.trim() !== '') {
                quill.clipboard.dangerouslyPasteHTML(inputEl.value);
            }

            quill.on('text-change', () => {
                inputEl.value = quill.root.innerHTML;
            });
        });
    </script>
