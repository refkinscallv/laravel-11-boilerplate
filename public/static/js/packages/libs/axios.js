window.Axios = class Axios {
    static req() {
        const instance = axios.create({
            baseURL: url('api'),
            headers: {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Cache-Control': 'no-store',
            },
            withCredentials: true,
        })

        // Interceptor request
        instance.interceptors.request.use(
            (config) => {
                return config
            },
            (error) => {
                console.error(`[Axios Request Error]`, error)
                return Promise.reject(error)
            },
        )

        // Interceptor response
        instance.interceptors.response.use(
            (response) => response,
            (error) => {
                console.error(`[Axios Response Error]`, error.response || error.message)
                return Promise.reject(error)
            },
        )

        return instance
    }
}
