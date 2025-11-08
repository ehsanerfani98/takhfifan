tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                'vazir': ['Vazirmatn', 'sans-serif'],
            },
            colors: {
                primary: '#2563eb',
                secondary: '#10b981',
                accent: '#f0f9ff',
                'text-dark': '#1f2937',
                'text-medium': '#374151',
                'text-light': '#6b7280',
                'text-lighter': '#9ca3af',
                'border-color': '#e5e7eb',
                beige: {
                    DEFAULT: '#f5f5dc',
                    light: '#f8f8e7',
                    dark: '#e5e5b5',
                },
                lavender: {
                    DEFAULT: '#E6E6FA',
                    light: '#F3F3FD',
                    dark: '#CFCFE8',
                },
                maroon: {
                    DEFAULT: '#800000',
                    dark: '#4B0000',
                    light: '#A52A2A',
                },
            },
            boxShadow: {
                'custom': '0 1px 3px rgba(0, 0, 0, 0.1)',
                'custom-light': '0 4px 6px rgba(0, 0, 0, 0.05)',
            },
            animation: {
                'slide-in-right': 'slideInRight 0.3s ease-out',
            },
            keyframes: {
                slideInRight: {
                    '0%': {
                        transform: 'translateX(100%)'
                    },
                    '100%': {
                        transform: 'translateX(0)'
                    },
                }
            }
        },
    }
}
