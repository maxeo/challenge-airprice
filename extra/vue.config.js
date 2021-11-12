//const path = require('path')

const host = '0.0.0.0'
const port = 8080

module.exports = {
    lintOnSave: false,
    devServer: {
        public: 'https://app-vue.docker.local:443',
        port,
        host,
        hotOnly: true,
        disableHostCheck: true,
        clientLogLevel: 'warning',
        inline: true,
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization'
        },
        watchOptions: {
            ignored: ['node_modules'],
            aggregateTimeout: 300,
            poll: 1500
        },
    }
}