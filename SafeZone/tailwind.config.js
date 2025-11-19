import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

// Tailwind configuration extended for broader template scanning and dark mode.
// Added app/View/Components and JS resources so dynamically rendered component classes are included.
// Enabled class-based dark mode and added a small safelist for common notification color utilities.
/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/View/Components/**/*.php",
        "./resources/js/**/*.js",
    ],
    safelist: [
        "text-cyan-400",
        "bg-cyan-400/10",
        "border-cyan-400/30",
        "bg-red-500/20",
        "text-red-400",
        "bg-orange-500/20",
        "text-orange-400",
        "bg-yellow-500/20",
        "text-yellow-400",
        "bg-blue-500/20",
        "text-blue-400",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
};
