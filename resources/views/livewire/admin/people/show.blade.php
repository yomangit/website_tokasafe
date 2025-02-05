<div>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.1.0/decoupled-document/ckeditor.js"></script>
    <div role="tablist" class="tabs tabs-lifted">
        <input type="radio" name="my_tabs_2" role="tab" checked="checked" class="tab" aria-label="Event" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            <livewire:admin.people.event :user_id="$user_id">
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab " aria-label="Tab 2" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            <div id="toolbar-container"></div>
            <div id="ckeditor5">
                <p>This is the initial editor content.</p>
            </div>
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Tab 3" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            Tab content 3
        </div>
    </div>
    @push('styles')
        <script src="https://cdn.ckeditor.com/ckeditor5/10.1.0/decoupled-document/ckeditor.js"></script>

        <script>
            DecoupledEditor
                .create(document.querySelector('#ckeditor5'), {
                    toolbar: ['bold', 'italic', 'underline', 'bulletedList', 'numberedList', 'link', 'blockQuote']
                })
                .then(editor => {
                    const toolbarContainer = document.querySelector('#toolbar-container');
                    toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush

</div>
