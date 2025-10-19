window.Prompt = class Prompt {
    static _resolver = null

    static make({
        message = 'Please enter:',
        body = `<input type="text" name="input" class="input w-full transition-all duration-200" />`,
        button = {
            okText: 'OK',
            cancelText: 'Cancel',
            okClass: 'btn btn-success',
            cancelClass: 'btn',
        },
    } = {}) {
        // Cleanup
        $('#prompt-modal, #prompt-backdrop').remove()

        // Destructure button config
        const { okText = 'OK', cancelText = 'Cancel', okClass = 'btn btn-success text-white', cancelClass = 'btn' } = button

        // Build modal HTML
        const modalHtml = $(`
            <dialog id="prompt-modal" class="modal modal-open z-[100000]">
                <form method="dialog" id="prompt-form" class="modal-box space-y-3">
                    <label class="font-bold block">${message}</label>
                    <div id="prompt-body">${body}</div>
                    <div class="modal-action flex justify-center items-center space-x-2">
                        <button type="submit" id="prompt-ok" class="${okClass}">${okText}</button>
                        <button type="button" id="prompt-cancel" class="${cancelClass}">${cancelText}</button>
                    </div>
                </form>
            </dialog>
        `)

        const backdrop = $(`<div id="prompt-backdrop" class="fixed inset-0 bg-black/40 z-[99999]"></div>`)

        $('body').prepend(modalHtml, backdrop)
        document.getElementById('prompt-modal').showModal()

        setTimeout(() => {
            $('#prompt-body input, #prompt-body textarea, #prompt-body select').first().focus()
        }, 100)

        // Cancel click
        $('#prompt-cancel, #prompt-backdrop').on('click', () => this._resolve(null))

        // Form submit
        $('#prompt-form').on('submit', function (e) {
            e.preventDefault()
            const data = {}
            $(this)
                .serializeArray()
                .forEach(({ name, value }) => {
                    data[name] = value
                })
            Prompt._resolve(data)
        })

        return new Promise((resolve) => {
            this._resolver = resolve
        })
    }

    static _resolve(value) {
        if (this._resolver) {
            this._resolver(value)
            this._resolver = null
        }
        $('#prompt-modal, #prompt-backdrop').remove()
    }
}
