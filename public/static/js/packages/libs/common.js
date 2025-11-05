window.Common = class Common {
    static payloadChecker(data = []) {
        if (!Array.isArray(data) || data.length === 0) {
            return { status: true, message: '' }
        }

        let invalid = null
        for (let i = data.length - 1; i >= 0; i--) {
            const item = data[i]
            if (item.value === '' || item.value === null) {
                invalid = item
                break
            }
        }

        return {
            status: !invalid,
            message: invalid?.message || '',
        }
    }

    static catchHandler(err, title = 'Error') {
        const message = err?.response?.data?.message || err?.response?.statusText || 'Unexpected error'
        const result = err?.response?.data?.data
        let details = ''

        if (Array.isArray(result)) {
            details = result.join('<br>')
        } else if (result && typeof result === 'object') {
            details = Object.values(result).flat().join('<br>')
        }

        const altResult = err?.response?.data?.result
        let altDetails = ''

        if (Array.isArray(altResult)) {
            altDetails = altResult
                .flatMap(r => Object.values(r.constraints || {}))
                .join('<br>')
        } else if (altResult && typeof altResult === 'object') {
            altDetails = Object.values(altResult).flat().join('<br>')
        }

        return Alert.make({
            icon: 'error',
            title,
            body: `${message}${details || altDetails ? '<br><br>' + (details || altDetails) : ''}`,
        })
    }

    static disabledButton(btn, label, status) {
        btn.prop('disabled', status).html(status ? 'Loading' : label)
    }

    static showHidePassword(toggle, el) {
        const toggleButton = $(toggle)
        const passwordEl = $(el)
        const passwordType = passwordEl.attr('type')

        passwordEl.attr('type', passwordType === 'password' ? 'text' : 'password')
        toggleButton.html(passwordType === 'password' ? `<i class="ri-eye-line"></i>` : `<i class="ri-eye-off-line"></i>`)
    }

    static collection(form) {
        const raw = form.serializeArray()
        const result = {}

        for (const { name, value } of raw) {
            const keys = name.match(/[^\[\]]+/g)
            if (!keys) continue

            let current = result

            for (let i = 0; i < keys.length; i++) {
                const key = keys[i]

                // If the next key is undefined and this is an array (because of empty [])
                const isLast = i === keys.length - 1
                const nextKey = keys[i + 1]

                if (nextKey === undefined && isLast) {
                    // End of path
                    if (Array.isArray(current)) {
                        current.push(value)
                    } else if (typeof current === 'object') {
                        current[key] = value
                    }
                } else if (nextKey === '') {
                    // For pattern like `payment_detail[]`
                    if (!current[key]) {
                        current[key] = []
                    }

                    // Ensure last element is an object (either empty or partially filled)
                    if (current[key].length === 0 || Object.keys(current[key][current[key].length - 1] || {}).length === keys.length - i - 1) {
                        current[key].push({})
                    }

                    current = current[key][current[key].length - 1]
                    i++ // Skip empty string key (because of [])
                } else {
                    // Regular object structure
                    if (!current[key]) current[key] = {}
                    current = current[key]
                }
            }
        }

        return result
    }

    static rupiah(value) {
        const num = Number(String(value).replace(/[^0-9-]/g, ''))
        if (isNaN(num)) return ''

        const isNegative = num < 0
        const absValue = Math.abs(num)

        const formatted = absValue
            .toString()
            .split('')
            .reverse()
            .join('')
            .match(/\d{1,3}/g)
            .join('.')
            .split('')
            .reverse()
            .join('')

        return (isNegative ? '-Rp ' : 'Rp ') + formatted
    }

    static toInt(value) {
        const number = parseInt(String(value).replace(/[^\d-]/g, ''), 10)
        return isNaN(number) ? 0 : number
    }

    static percent(el) {
        const input = $(el)
        const val = input.val()
        const number = val.replace(/[^\d]/g, '')

        if (!number) {
            input.val('')
            return
        }

        const formatted = number + '%'
        input.val(formatted)
        el.setSelectionRange(formatted.length - 1, formatted.length - 1)
    }

    static uniqid(prefix = '', moreEntropy = false) {
        const now = Date.now()
        const random = Math.floor(Math.random() * 1e8)
        let id = now.toString(16) + random.toString(16)

        if (moreEntropy) {
            id += (Math.random() * 10).toFixed(8).toString().replace('.', '')
        }

        return prefix + id
    }

    static formDataExcept(formData, exclude = []) {
        const newFormData = new FormData()
        const existingFormData = new FormData(formData[0])
        for (const [key, value] of existingFormData.entries()) {
            if (!exclude.includes(key)) {
                newFormData.append(key, value)
            }
        }
        return newFormData
    }

    static cleanUandUC(str) {
        return str.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase())
    }

    static DateYmdhis(dateStr) {
        const date = new Date(dateStr)
        const Y = date.getFullYear()
        const m = String(date.getMonth() + 1).padStart(2, '0')
        const d = String(date.getDate()).padStart(2, '0')
        const H = String(date.getHours()).padStart(2, '0')
        const i = String(date.getMinutes()).padStart(2, '0')
        const s = String(date.getSeconds()).padStart(2, '0')
        return `${Y}-${m}-${d} ${H}:${i}:${s}`
    }

    static mb_strimwidth(str, start, width, trimMarker = '') {
        if (typeof str !== 'string') return ''

        const chars = [...str]
        let result = ''
        let currentWidth = 0

        for (let i = start; i < chars.length; i++) {
            const char = chars[i]
            const charWidth = char.match(/[ -~]/) ? 1 : 2

            if (currentWidth + charWidth > width) {
                result += trimMarker
                break
            }

            result += char
            currentWidth += charWidth
        }

        return result
    }

    static removeArrayByIndex(arr, index) {
        if (index >= 0 && index < arr.length) {
            arr.splice(index, 1)
        }
        return arr
    }

    static removeArrayObjectByKey(arr, key, value) {
        return arr.filter((item) => item[key] !== value)
    }

    static removeObjectKey(obj, key) {
        if (obj.hasOwnProperty(key)) {
            delete obj[key]
        }
        return obj
    }

    static createTable(element, config = {}) {
        return element.DataTable({
            autoWidth: false,
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                processing: 'Processing...',
                search: 'Search:&emsp;',
                lengthMenu: '_MENU_&emsp;rows',
                info: 'Showing _START_ - _END_ of _TOTAL_ rows',
                infoEmpty: 'Showing 0 - 0 of 0 rows',
                infoFiltered: '(Filtered from _MAX_ total rows)',
                loadingRecords: 'Loading...',
                zeroRecords: 'No matching data found',
                emptyTable: 'No data available in table',
                paginate: {
                    first: 'First',
                    previous: 'Previous',
                    next: 'Next',
                    last: 'Last',
                },
            },
            ...config,
        })
    }

    static createSelect(data) {
        const { el = null, url = '', col = ['id', 'name'], search = 'Search...', max = 10, setValue = null, ...opts } = data

        const instance = new TomSelect(el, {
            valueField: col[0],
            labelField: col[1],
            searchField: col[1],
            placeholder: search,
            maxOptions: max,
            persist: opts?.create ?? false,
            preload: opts?.create ?? true,
            create: opts?.create ?? false,
            dropdownParent: 'body',
            ...opts,

            render: {
                option: (data, escape) => `<div class="py-1 px-2">${escape(data[col[1]])}</div>`,
                no_results: () => `<div class="px-2 py-1 text-gray-500">No results found</div>`,
                loading: () => null,
                ...(opts?.render ? opts.render : {})
            },

            load: (query, callback) => {
                const wrapper = $(el).next('.ts-wrapper')
                wrapper.addClass('loading')
                $('#loader').removeClass('hidden')

                Axios.req()
                    .get(url.replace(/^\/+/, ''), { params: { q: query } })
                    .then((res) => {
                        const results = res.data
                        callback(results)

                        if (setValue !== null) {
                            instance.setValue(setValue)
                        }

                        wrapper.removeClass('loading')
                        $('#loader').addClass('hidden')
                    })
                    .catch(() => {
                        wrapper.removeClass('loading')
                        $('#loader').addClass('hidden')
                        callback()
                    })
            },
        })

        return instance
    }

    static kmbFormat(number, precision = 1) {
        if (number < 1000) return String(number)

        const units = ['', 'K', 'M', 'B', 'T']
        const base = 1000
        const i = Math.floor(Math.log(number) / Math.log(base))
        const value = number / Math.pow(base, i)

        return value.toFixed(precision).replace(/\.0+$/, '') + units[i]
    }

    static randNum(min = 1, max = 100, count = 6) {
        const numbers = Array.from(
            { length: max - min + 1 },
            (_, i) => i + min
        )

        const shuffled = numbers.sort(() => 0.5 - Math.random())

        return shuffled.slice(0, count)
    }

    static sleep(ms = 1000) {
        return new Promise(resolve => setTimeout(resolve, ms))
    }

    static loadingToggle(sh = false) {
        const loadingElement = $('#loading-overlay')
        if (sh) {
            loadingElement.removeClass('hidden')
        } else {
            loadingElement.addClass('hidden')
        }
    }

    static ucwords(str = '') {
        return str.replace(/\b\w/g, (char) => char.toUpperCase())
    }
}
