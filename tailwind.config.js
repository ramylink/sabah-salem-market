/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#E8F5E9',
                    100: '#C8E6C9',
                    200: '#A5D6A7',
                    300: '#81C784',
                    400: '#66BB6A',
                    500: '#4CAF50',
                    600: '#43A047',
                    700: '#388E3C',
                    800: '#2E7D32',
                    900: '#1B5E20',
                    950: '#0D3B10',
                },
                accent: {
                    50: '#FFF8E1',
                    100: '#FFECB3',
                    200: '#FFE082',
                    300: '#FFD54F',
                    400: '#FFCA28',
                    500: '#FFC107',
                    600: '#FFB300',
                    700: '#FFA000',
                    800: '#FF8F00',
                    900: '#FF6F00',
                },
                danger: {
                    50: '#FFEBEE',
                    100: '#FFCDD2',
                    500: '#F44336',
                    600: '#E53935',
                    700: '#D32F2F',
                },
                warm: {
                    50: '#FAFAFA',
                    100: '#F5F5F5',
                    200: '#EEEEEE',
                    300: '#E0E0E0',
                    400: '#BDBDBD',
                    500: '#9E9E9E',
                    600: '#757575',
                    700: '#616161',
                    800: '#424242',
                    900: '#212121',
                }
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                arabic: ['Noto Sans Arabic', 'Tajawal', 'system-ui', 'sans-serif'],
            },
            animation: {
                'fade-in': 'fadeIn 0.3s ease-out',
                'slide-up': 'slideUp 0.4s ease-out',
                'slide-down': 'slideDown 0.3s ease-out',
                'bounce-soft': 'bounceSoft 0.5s ease-in-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'spin-slow': 'spin 2s linear infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                slideDown: {
                    '0%': { transform: 'translateY(-10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                bounceSoft: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%': { transform: 'scale(1.05)' },
                }
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
            boxShadow: {
                'soft': '0 2px 15px rgba(0,0,0,0.08)',
                'medium': '0 4px 25px rgba(0,0,0,0.12)',
                'strong': '0 8px 40px rgba(0,0,0,0.16)',
                'glow': '0 0 20px rgba(76, 175, 80, 0.3)',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
