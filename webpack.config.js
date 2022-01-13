const path = require('path')
const webpack = require('webpack')

module.exports = {
    optimization: {
        providedExports: false,
        sideEffects: false,
        usedExports: false
    },
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '@': path.resolve(__dirname, './resources/js/admin'),
            '@assets': path.resolve(__dirname, './resources/assets'),
            '@sass': path.resolve(__dirname, './resources/sass')
        }
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                MIX_APP_URL: JSON.stringify(process.env.APP_URL),
                MIX_APP_NAME: JSON.stringify(process.env.APP_NAME),
            }
        }),
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
        new webpack.ProvidePlugin({
            'window.Quill': 'quill'
        })
    ],
    watchOptions: {ignored: /node_modules/}
}
