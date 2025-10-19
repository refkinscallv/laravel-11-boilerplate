// External
import 'https://code.jquery.com/jquery-3.7.1.min.js'
import 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js'
import 'https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js'
import 'https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.3.4/b-3.2.5/b-colvis-3.2.5/b-print-3.2.5/r-3.0.7/datatables.min.js'

// Internal
import './libs/alert.js'
import './libs/axios.js'
import './libs/common.js'
import './libs/prompt.js'
import './libs/state.js'

// Define
$(window).on('load', () => {
    // Theme mode toggle
    const themeModeStatus = localStorage.getItem('themeMode')
    const btnThemeModeToggle = $('#btnThemeModeToggle')
    if (btnThemeModeToggle.length) {
        $('#btnThemeModeToggle')
            .find('#icon')
            .removeClass()
            .addClass(themeModeStatus === 'dark' ? 'ri-sun-line' : 'ri-moon-line')
        $('#btnThemeModeToggle').on('click', () => {
            const themeNow = $('html').attr('data-theme')
            const themeNew = themeNow === 'dark' ? 'light' : 'dark'
            $('html').attr('data-theme', themeNew)
            localStorage.setItem('themeMode', themeNew)
            $('#btnThemeModeToggle')
                .find('#icon')
                .removeClass()
                .addClass(themeNew === 'dark' ? 'ri-sun-line' : 'ri-moon-line')
        })
    }
})

$(document).ready(() => {
    // disabled right click
    $(document).on('contextmenu', (e) => {
        e.preventDefault()
    })

    // show all flash
    if (typeof showFlash !== 'undefined') {
        if (showFlash && Object.keys(showFlash).length > 0) {
            $.each(showFlash, (key, value) => {
                Alert.make({
                    icon: key,
                    body: value,
                })
            })
        }
    }

    // image preview
    $(document).on('click', 'img[data-preview]', function () {
        const imgSrc = $(this).attr('src')
        $('#image-preview-target').attr('src', imgSrc)
        $('#image-preview-overlay').removeClass('hidden').addClass('flex')
    })

    const imagePreview = $('#close-preview, #image-preview-overlay')
    if (imagePreview.length) {
        $('#close-preview, #image-preview-overlay').on('click', function (e) {
            if (e.target.id === 'image-preview-target') return
            $('#image-preview-overlay').removeClass('flex').addClass('hidden')
        })
    }
})
