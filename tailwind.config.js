/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        fontFamily: {
            rubik: ["Rubik Variable", "sans-serif"],
            plus: ["Plus Jakarta Sans Variable"],
        },
    },
    plugins: [require("flowbite/plugin"), require("tailwindcss-animated")],
};
