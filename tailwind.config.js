const preset = require('../../../vendor/filament/filament/tailwind.config.preset')
const fs = require('fs')

const tailwindColors = require('tailwindcss/colors')
const baseConfigExists = fs.existsSync('../../../tailwind.config.js')
const colors = baseConfigExists ?  { ...tailwindColors, ...require('../../../tailwind.config.js').theme.extend.colors } : tailwindColors

module.exports = {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                ...colors,
            }
        }
    }
}




