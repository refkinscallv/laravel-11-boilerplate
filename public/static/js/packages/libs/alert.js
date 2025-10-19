window.Alert = class Alert {
    static icon = {
        default: 'ri-alarm-warning-line',
        success: 'ri-checkbox-circle-line',
        error: 'ri-close-circle-line',
        warning: 'ri-error-warning-line',
        info: 'ri-information-line',
        question: 'ri-question-line',
    }

    static iconColor = {
        default: 'text-primary',
        success: 'text-success',
        error: 'text-error',
        warning: 'text-warning',
        info: 'text-info',
        question: 'text-primary',
    }

    static buttonColor = {
        default: 'btn-primary',
        success: 'btn-success',
        error: 'btn-error',
        warning: 'btn-warning',
        info: 'btn-info',
        question: 'btn-primary',
    }

    static make(opt = {}) {
        return new Promise((resolve) => {
            const { icon = 'default', title = '', body = '', showCancel = false, confirm = { text: 'Ok' }, cancel = { text: 'Close' } } = opt

            const iconKey = this.icon[icon] ? icon : 'default'
            const modalId = `modal_alert_${Common.uniqid()}`
            const container = $('swal')

            const html = `
<dialog id="${modalId}" class="modal bg-black/40 backdrop-blur-sm transition-opacity duration-300 ease-out opacity-0">
    <div class="modal-box max-h-[90vh] overflow-auto text-center bg-base-100 rounded-xl shadow-xl">
        <div class="mb-2">
            <i class="${this.icon[iconKey]} text-[80px] ${this.iconColor[iconKey]} animate-pulse"></i>
        </div>
        ${title ? `<h3 class="text-2xl font-bold mb-4">${title}</h3>` : ''}
        <div class="text-base-content mb-6 leading-relaxed">${body}</div>
        <div class="modal-action flex justify-center gap-2">
            <button id="clickConfirmButton" type="button" class="btn ${confirm?.color ?? this.buttonColor[iconKey]} btn-sm lg:btn-md">${confirm.text}</button>
            ${showCancel ? `<button id="clickCancelButton" type="button" class="btn ${cancel?.color ?? ''} btn-sm lg:btn-md">${cancel.text}</button>` : ''}
        </div>
    </div>
</dialog>
            `

            container.append(html)
            const $modal = $(`#${modalId}`)
            const dialogEl = $modal[0]

            setTimeout(() => {
                dialogEl.showModal()
                $modal.removeClass('opacity-0').addClass('opacity-100')
            }, 10)

            dialogEl.addEventListener('cancel', (e) => {
                e.preventDefault()
                if (showCancel) {
                    resolve({ isConfirmed: false })
                    dialogEl.close()
                }
            })

            $modal.find('#clickConfirmButton').on('click', () => {
                resolve({ isConfirmed: true })
                dialogEl.close()
            })

            $modal.find('#clickCancelButton').on('click', () => {
                resolve({ isConfirmed: false })
                dialogEl.close()
            })

            $modal.on('close', () => {
                $modal.removeClass('opacity-100').addClass('opacity-0')
                setTimeout(() => $modal.remove(), 250)
            })
        })
    }
}
