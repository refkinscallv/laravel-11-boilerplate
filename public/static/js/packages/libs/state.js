window.State = class State {
    static _state = {}
    static _listeners = {}

    static set(key, valueOrFn) {
        const oldValue = this._state[key]

        const newValue = typeof valueOrFn === 'function' ? valueOrFn(oldValue) : valueOrFn

        this._state[key] = newValue

        if (this._listeners[key] && oldValue !== newValue) {
            this._listeners[key].forEach((fn) => fn(newValue, oldValue))
        }
    }

    static get(key) {
        return this._state[key]
    }

    static has(key) {
        return Object.prototype.hasOwnProperty.call(this._state, key)
    }

    static remove(key) {
        if (this.has(key)) {
            const oldValue = this._state[key]
            delete this._state[key]
            if (this._listeners[key]) {
                this._listeners[key].forEach((fn) => fn(undefined, oldValue))
            }
        }
    }

    static clearAll() {
        for (const key in this._state) {
            this.remove(key)
        }
    }

    static all() {
        return { ...this._state }
    }

    static onChange(key, fn) {
        if (!this._listeners[key]) {
            this._listeners[key] = []
        }
        this._listeners[key].push(fn)
    }

    static offChange(key, fn) {
        if (!this._listeners[key]) return

        if (!fn) {
            delete this._listeners[key]
        } else {
            this._listeners[key] = this._listeners[key].filter((cb) => cb !== fn)
            if (this._listeners[key].length === 0) {
                delete this._listeners[key]
            }
        }
    }

    static use(key, initial = null) {
        if (!this.has(key)) this.set(key, initial)
        return [() => this.get(key), (v) => this.set(key, v)]
    }

    static batch(updates = {}) {
        Object.entries(updates).forEach(([key, valueOrFn]) => {
            this.set(key, valueOrFn)
        })
    }

    static toggle(key) {
        const current = this.get(key)
        this.set(key, !current)
    }

    static increment(key, by = 1) {
        const current = this.get(key) ?? 0
        this.set(key, current + by)
    }

    static decrement(key, by = 1) {
        const current = this.get(key) ?? 0
        this.set(key, current - by)
    }
}
