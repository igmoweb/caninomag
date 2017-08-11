const merge = require('webpack-merge');
const path = require( 'path' );
const ExtractTextPlugin = require( "extract-text-webpack-plugin" );
const SystemBellPlugin = require('system-bell-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');

const commonPlugins = () => {
    return {
        plugins: [
            new SystemBellPlugin(), // Makes a beep when an error is found
            new FriendlyErrorsWebpackPlugin() // Better errors display
        ]
    }
};

const devTool = ( production ) => {
    if ( production ) {
        // Slower to process
        return { devtool: 'source-map' }
    }
    else {
        return { devtool: 'eval-source-map' }
    }
};

const sassCommonConfig = ( production ) => {
    // Webpack just understands JS, not CSS or Sass.
    // This section, generates a file called foundation.js that contains all CSS styles in a variable
    // But then ExtractTextPlugin will move it to a CSS file
    const extractSass = new ExtractTextPlugin( {
        filename: function( getPath ) {
            return getPath( '[name].css' ).replace( 'css/js', 'css' );
        }
    } );

    return {
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    // Extract CSS from foundation.js and move it to a css file
                    use: extractSass.extract( {
                        // Last item is first processed
                        // I don't actually understand the whole process but it works :)
                        use: [
                            // 2. Process CSS
                            {
                                loader: "css-loader",
                                options: {
                                    sourceMap: true,
                                    url:false
                                }
                            },
                            // 1. Make Webpack to understand Sass and process it to JS
                            {
                                loader: "sass-loader",
                                options: {
                                    sourceMap: true
                                },
                            },
                        ],
                        fallback: "style-loader"
                    } )
                }
            ]
        },
        plugins:[
            extractSass
        ]
    }
};

const JSConfig = ( production = false ) => {
    return merge(
        [
            {
                entry: [
                    './bower_components/foundation-sites/js/foundation.core.js',
                    './bower_components/foundation-sites/js/foundation.util.mediaQuery.js',
                    './bower_components/foundation-sites/js/foundation.sticky.js',
                    './bower_components/foundation-sites/js/foundation.dropdownMenu.js',
                    './bower_components/foundation-sites/js/foundation.responsiveToggle.js',
                    './bower_components/foundation-sites/js/foundation.util.touch.js'
                ],
                output: {
                    filename: 'foundation.min.js',
                    path: path.resolve(__dirname, "js")
                },
                module: {
                    rules: [
                        {
                            test: /\.js$/,
                            loader: 'babel-loader',
                            options: {
                                presets: [ 'es2015' ], // Transform ES6 to Vanilla JS
                                plugins: [ "transform-class-properties" ] // This plugin allows to define static properties in ES6. Really useful.
                            }
                        }
                    ]
                }
            },
            devTool( production ),
            commonPlugins()
        ]
    );
};

const SassConfig = ( production ) => {

    return merge(
        [
            {
                entry: {'app':'./scss/app.js'},
                output: {
                    filename: 'app.js',
                    path: path.resolve(__dirname, "css")
                }
            },
            sassCommonConfig( production ),
            devTool( production ),
            commonPlugins()
        ]
    );
};

const editorStyleConfig = ( production ) => {

    return merge(
        [
            {
                entry: {'editor-style':'./scss/editor-style.js'},
                output: {
                    filename: 'editor-style.js',
                    path: path.resolve(__dirname)
                }
            },
            sassCommonConfig( production ),
            devTool( production ),
            commonPlugins()
        ]
    );
};


module.exports = ( env ) => {
    let production = false;
    if ( ! ( typeof env === 'undefined' ) ) {
        production = env.production || false;
    }

    return [ JSConfig( production ), editorStyleConfig( production ), SassConfig( production ) ];
};